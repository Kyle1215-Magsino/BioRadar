<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Assessment;
use App\Models\Symptom;
use App\Services\RiskAssessmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    protected $riskAssessmentService;

    public function __construct(RiskAssessmentService $riskAssessmentService)
    {
        $this->riskAssessmentService = $riskAssessmentService;
    }

    /**
     * Display patient dashboard
     */
    public function dashboard()
    {
        $patient = auth()->user()->patient;
        
        if (!$patient) {
            // Create patient profile if it doesn't exist
            $patient = Patient::create([
                'user_id' => auth()->id(),
            ]);
        }

        $stats = [
            'total_assessments' => $patient->assessments()->count(),
            'pending_assessments' => $patient->assessments()->where('status', 'pending')->count(),
            'completed_assessments' => $patient->assessments()->where('status', 'completed')->count(),
        ];

        $recentAssessments = $patient->assessments()
            ->with(['doctor.user', 'riskEvaluation'])
            ->latest()
            ->limit(5)
            ->get();

        return view('patient.dashboard', compact('patient', 'stats', 'recentAssessments'));
    }

    /**
     * Show patient profile
     */
    public function profile()
    {
        $patient = auth()->user()->patient;
        return view('patient.profile', compact('patient'));
    }

    /**
     * Update patient profile
     */
    public function updateProfile(Request $request)
    {
        $patient = auth()->user()->patient;

        $validated = $request->validate([
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'height' => 'nullable|numeric|min:50|max:300',
            'weight' => 'nullable|numeric|min:20|max:500',
            'blood_group' => 'nullable|string|max:10',
            'medical_history' => 'nullable|string',
        ]);

        $patient->update($validated);

        // Calculate BMI if height and weight are provided
        if ($patient->height && $patient->weight) {
            $patient->calculateBmi();
        }

        return redirect()->route('patient.profile')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Show new assessment form
     */
    public function createAssessment()
    {
        $symptoms = Symptom::active()->orderBy('category')->orderBy('name')->get();
        return view('patient.create-assessment', compact('symptoms'));
    }

    /**
     * Submit automated assessment
     */
    public function submitAutomatedAssessment(Request $request)
    {
        $patient = auth()->user()->patient;

        $validated = $request->validate([
            'symptoms' => 'required|array|min:1',
            'symptoms.*' => 'exists:symptoms,id',
            'severity.*' => 'nullable|in:mild,moderate,severe',
            'duration_days.*' => 'nullable|integer|min:1',
            'additional_notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Create assessment
            $assessment = Assessment::create([
                'patient_id' => $patient->id,
                'assessment_type' => 'automated',
                'additional_notes' => $validated['additional_notes'] ?? null,
                'status' => 'completed',
                'submitted_at' => now(),
                'completed_at' => now(),
            ]);

            // Attach symptoms
            foreach ($validated['symptoms'] as $symptomId) {
                $assessment->symptoms()->attach($symptomId, [
                    'severity' => $request->input("severity.{$symptomId}"),
                    'duration_days' => $request->input("duration_days.{$symptomId}"),
                ]);
            }

            // Calculate automated risk
            $riskEvaluation = $this->riskAssessmentService->calculateAutomatedRisk($assessment);

            DB::commit();

            return redirect()->route('patient.assessment.result', $assessment)
                ->with('success', 'Assessment completed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error submitting assessment: ' . $e->getMessage());
        }
    }

    /**
     * Submit assessment for doctor review
     */
    public function submitDoctorReview(Request $request)
    {
        $patient = auth()->user()->patient;

        $validated = $request->validate([
            'symptoms' => 'required|array|min:1',
            'symptoms.*' => 'exists:symptoms,id',
            'severity.*' => 'nullable|in:mild,moderate,severe',
            'duration_days.*' => 'nullable|integer|min:1',
            'additional_notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Create assessment
            $assessment = Assessment::create([
                'patient_id' => $patient->id,
                'assessment_type' => 'doctor_review',
                'additional_notes' => $validated['additional_notes'] ?? null,
                'status' => 'pending',
                'submitted_at' => now(),
            ]);

            // Attach symptoms
            foreach ($validated['symptoms'] as $symptomId) {
                $assessment->symptoms()->attach($symptomId, [
                    'severity' => $request->input("severity.{$symptomId}"),
                    'duration_days' => $request->input("duration_days.{$symptomId}"),
                ]);
            }

            DB::commit();

            return redirect()->route('patient.assessments')
                ->with('success', 'Assessment submitted for doctor review.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error submitting assessment: ' . $e->getMessage());
        }
    }

    /**
     * View all assessments
     */
    public function assessments(Request $request)
    {
        $patient = auth()->user()->patient;
        $query = $patient->assessments()
            ->with(['doctor.user', 'riskEvaluation', 'symptoms']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by assessment type
        if ($request->filled('type')) {
            $query->where('assessment_type', $request->type);
        }

        $assessments = $query->latest()->paginate(15)->withQueryString();

        return view('patient.assessments', compact('assessments'));
    }

    /**
     * View assessment result
     */
    public function viewAssessment(Assessment $assessment)
    {
        // Check if this assessment belongs to the logged-in patient
        if ($assessment->patient_id !== auth()->user()->patient->id) {
            abort(403, 'Unauthorized to view this assessment.');
        }

        $assessment->load(['symptoms', 'doctor.user', 'riskEvaluation']);
        return view('patient.assessment-result', compact('assessment'));
    }
}
