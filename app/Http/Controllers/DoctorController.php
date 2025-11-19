<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\RiskEvaluation;
use App\Models\Patient;
use App\Services\RiskAssessmentService;
use App\Notifications\RiskEvaluationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    protected $riskAssessmentService;

    public function __construct(RiskAssessmentService $riskAssessmentService)
    {
        $this->riskAssessmentService = $riskAssessmentService;
    }

    /**
     * Display doctor dashboard
     */
    public function dashboard()
    {
        $doctor = auth()->user()->doctor;
        
        $stats = [
            'pending_assessments' => Assessment::where('doctor_id', $doctor->id)
                ->where('status', 'pending')
                ->count(),
            'completed_assessments' => Assessment::where('doctor_id', $doctor->id)
                ->where('status', 'completed')
                ->count(),
            'total_patients' => Assessment::where('doctor_id', $doctor->id)
                ->distinct('patient_id')
                ->count('patient_id'),
        ];

        $recentAssessments = Assessment::where('doctor_id', $doctor->id)
            ->with(['patient.user', 'riskEvaluation'])
            ->latest()
            ->limit(5)
            ->get();

        return view('doctor.dashboard', compact('stats', 'recentAssessments'));
    }

    /**
     * View all assessments assigned to doctor
     */
    public function assessments(Request $request)
    {
        $doctor = auth()->user()->doctor;
        
        $query = Assessment::with(['patient.user', 'riskEvaluation', 'symptoms']);

        // Filter by my reviews or all
        if ($request->filled('my_reviews') && $request->my_reviews == '1') {
            $query->where('doctor_id', $doctor->id);
        }

        // Search by patient name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $assessments = $query->latest()->paginate(15)->withQueryString();

        // Calculate stats
        $stats = [
            'total' => Assessment::count(),
            'reviewed' => Assessment::where('doctor_id', $doctor->id)->count(),
            'pending' => Assessment::where('status', 'pending')->count(),
        ];

        return view('doctor.assessments', compact('assessments', 'stats'));
    }

    /**
     * View pending assessments needing review
     */
    public function pendingAssessments()
    {
        $assessments = Assessment::where('status', 'pending')
            ->whereNull('doctor_id')
            ->orWhere('doctor_id', auth()->user()->doctor->id)
            ->with(['patient.user', 'symptoms'])
            ->latest()
            ->paginate(15);

        $pendingCount = Assessment::where('status', 'pending')->count();
        $uniquePatientsCount = Assessment::where('status', 'pending')
            ->distinct('patient_id')
            ->count('patient_id');

        return view('doctor.pending-assessments', compact('assessments', 'pendingCount', 'uniquePatientsCount'));
    }

    /**
     * View specific assessment for review
     */
    public function viewAssessment(Assessment $assessment)
    {
        // Check if doctor can access this assessment
        if ($assessment->doctor_id && $assessment->doctor_id !== auth()->user()->doctor->id) {
            abort(403, 'Unauthorized to view this assessment.');
        }

        $assessment->load(['patient.user', 'symptoms', 'riskEvaluation']);
        
        return view('doctor.assessment-review', compact('assessment'));
    }

    /**
     * Claim an assessment for review
     */
    public function claimAssessment(Assessment $assessment)
    {
        if ($assessment->doctor_id) {
            return redirect()->back()->with('error', 'This assessment is already assigned to a doctor.');
        }

        $assessment->update([
            'doctor_id' => auth()->user()->doctor->id,
            'status' => 'in_progress',
        ]);

        return redirect()->route('doctor.assessment.review', $assessment)
            ->with('success', 'Assessment claimed successfully.');
    }

    /**
     * Submit risk evaluation
     */
    public function submitEvaluation(Request $request, Assessment $assessment)
    {
        $validated = $request->validate([
            'risk_percentage' => 'required|numeric|min:0|max:100',
            'evaluation_notes' => 'required|string',
            'recommendations' => 'required|string',
            'send_email' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            // Create or update risk evaluation
            $riskEvaluation = RiskEvaluation::updateOrCreate(
                ['assessment_id' => $assessment->id],
                [
                    'doctor_id' => auth()->user()->doctor->id,
                    'risk_percentage' => $validated['risk_percentage'],
                    'evaluation_notes' => $validated['evaluation_notes'],
                    'recommendations' => $validated['recommendations'],
                ]
            );

            // Update assessment status
            $assessment->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            // Send email notification if requested
            if ($request->boolean('send_email')) {
                $assessment->patient->user->notify(new RiskEvaluationNotification($riskEvaluation));
                $riskEvaluation->update([
                    'email_sent' => true,
                    'email_sent_at' => now(),
                ]);
            }

            DB::commit();

            return redirect()->route('doctor.assessments')
                ->with('success', 'Risk evaluation submitted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error submitting evaluation: ' . $e->getMessage());
        }
    }

    /**
     * View patient details
     */
    public function viewPatient(Patient $patient)
    {
        $patient->load(['user', 'assessments.riskEvaluation']);
        return view('doctor.patient-details', compact('patient'));
    }
}
