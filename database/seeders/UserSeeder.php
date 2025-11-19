<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@bioradar.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create Doctor
        $doctorUser = User::create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'doctor@bioradar.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
            'is_active' => true,
        ]);

        Doctor::create([
            'user_id' => $doctorUser->id,
            'specialization' => 'Oncology',
            'license_number' => 'LIC-2024-001',
            'qualifications' => 'MD, PhD in Oncology',
            'phone' => '+1234567890',
        ]);

        // Create Patient
        $patientUser = User::create([
            'name' => 'John Doe',
            'email' => 'patient@bioradar.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'is_active' => true,
        ]);

        Patient::create([
            'user_id' => $patientUser->id,
            'date_of_birth' => '1985-05-15',
            'gender' => 'male',
            'phone' => '+1234567891',
            'height' => 175.0,
            'weight' => 75.0,
            'blood_group' => 'O+',
        ]);

        // Calculate BMI for patient
        $patientUser->patient->calculateBmi();
    }
}
