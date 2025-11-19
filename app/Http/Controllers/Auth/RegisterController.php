<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Show the registration form
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:patient,doctor'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => true,
        ]);

        // Create associated profile based on role
        if ($user->role === 'doctor') {
            Doctor::create([
                'user_id' => $user->id,
                'license_number' => 'LIC-' . time() . '-' . $user->id,
            ]);
        } elseif ($user->role === 'patient') {
            Patient::create([
                'user_id' => $user->id,
            ]);
        }

        Auth::login($user);

        // Redirect based on role
        return match($user->role) {
            'doctor' => redirect()->route('doctor.dashboard'),
            'patient' => redirect()->route('patient.dashboard'),
            default => redirect('/'),
        };
    }
}
