<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Assessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_patients' => Patient::count(),
            'total_doctors' => Doctor::count(),
            'total_assessments' => Assessment::count(),
            'pending_assessments' => Assessment::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Display all users
     */
    public function users()
    {
        $users = User::with(['doctor', 'patient'])->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show create user form
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Store a new user
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'doctor', 'patient'])],
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        // Create associated profile based on role
        if ($user->role === 'doctor') {
            Doctor::create([
                'user_id' => $user->id,
                'license_number' => 'LIC-' . time(),
            ]);
        } elseif ($user->role === 'patient') {
            Patient::create([
                'user_id' => $user->id,
            ]);
        }

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }

    /**
     * Show edit user form
     */
    public function editUser(User $user)
    {
        $user->load(['doctor', 'patient']);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'is_active' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    /**
     * Remove user
     */
    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    /**
     * View all assessments
     */
    public function assessments(Request $request)
    {
        $query = Assessment::with(['patient.user', 'doctor.user', 'riskEvaluation']);

        // Search by patient name or email
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

        // Filter by assessment type
        if ($request->filled('type')) {
            $query->where('assessment_type', $request->type);
        }

        // Filter by risk level
        if ($request->filled('risk_level')) {
            $query->whereHas('riskEvaluation', function($q) use ($request) {
                $q->where('risk_level', $request->risk_level);
            });
        }

        $assessments = $query->latest()->paginate(20)->withQueryString();
        
        return view('admin.assessments.index', compact('assessments'));
    }

    /**
     * View specific assessment details
     */
    public function viewAssessment(Assessment $assessment)
    {
        $assessment->load(['patient.user', 'doctor.user', 'symptoms', 'riskEvaluation']);
        return view('admin.assessment-details', compact('assessment'));
    }
}
