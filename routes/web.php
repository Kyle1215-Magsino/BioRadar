<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::middleware('auth')->group(function () {
    // Dashboard redirect based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        return match($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'doctor' => redirect()->route('doctor.dashboard'),
            'patient' => redirect()->route('patient.dashboard'),
            default => redirect('/'),
        };
    })->name('dashboard');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    // Assessment Viewing
    Route::get('/assessments', [AdminController::class, 'assessments'])->name('assessments');
    Route::get('/assessments/{assessment}', [AdminController::class, 'viewAssessment'])->name('assessments.view');
});

// Doctor Routes
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
    
    // Assessment Management
    Route::get('/assessments', [DoctorController::class, 'assessments'])->name('assessments');
    Route::get('/assessments/pending', [DoctorController::class, 'pendingAssessments'])->name('assessments.pending');
    Route::get('/assessments/{assessment}', [DoctorController::class, 'viewAssessment'])->name('assessment.review');
    Route::post('/assessments/{assessment}/claim', [DoctorController::class, 'claimAssessment'])->name('assessment.claim');
    Route::post('/assessments/{assessment}/evaluate', [DoctorController::class, 'submitEvaluation'])->name('assessment.evaluate');
    
    // Patient Viewing
    Route::get('/patients/{patient}', [DoctorController::class, 'viewPatient'])->name('patient.view');
});

// Patient Routes
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    
    // Profile Management
    Route::get('/profile', [PatientController::class, 'profile'])->name('profile');
    Route::put('/profile', [PatientController::class, 'updateProfile'])->name('profile.update');
    
    // Assessment Submission
    Route::get('/assessment/create', [PatientController::class, 'createAssessment'])->name('assessment.create');
    Route::post('/assessment/automated', [PatientController::class, 'submitAutomatedAssessment'])->name('assessment.automated');
    Route::post('/assessment/doctor-review', [PatientController::class, 'submitDoctorReview'])->name('assessment.doctor-review');
    
    // View Assessments
    Route::get('/assessments', [PatientController::class, 'assessments'])->name('assessments');
    Route::get('/assessments/{assessment}', [PatientController::class, 'viewAssessment'])->name('assessment.result');
});

require __DIR__.'/auth.php';
