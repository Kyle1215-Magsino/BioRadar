@extends('layouts.app')

@section('title', 'My Profile')

@push('scripts')
<script>
$(document).ready(function() {
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#40C9A2',
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#ef4444'
        });
    @endif
});
</script>
@endpush

@section('content')
<div class="max-w-4xl mx-auto animate__animated animate__fadeIn">
    <div class="mb-6">
        <a href="{{ route('patient.dashboard') }}" class="text-[#1B9AAA] hover:text-[#40C9A2] flex items-center font-semibold transition duration-200">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Dashboard
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-8 border border-[#D3F9D8]">
        <h1 class="text-3xl font-bold text-[#1B9AAA] mb-6">My Profile</h1>

        <form method="POST" action="{{ route('patient.profile.update') }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name (read-only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input type="text" 
                           value="{{ auth()->user()->name }}" 
                           disabled
                           class="w-full border-gray-300 rounded-md shadow-sm bg-gray-50">
                </div>

                <!-- Email (read-only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" 
                           value="{{ auth()->user()->email }}" 
                           disabled
                           class="w-full border-gray-300 rounded-md shadow-sm bg-gray-50">
                </div>

                <!-- Date of Birth -->
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                    <input type="date" 
                           name="date_of_birth" 
                           id="date_of_birth"
                           value="{{ old('date_of_birth', $patient->date_of_birth?->format('Y-m-d')) }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200">
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                    <select name="gender" 
                            id="gender"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender', $patient->gender) === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $patient->gender) === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender', $patient->gender) === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" 
                           name="phone" 
                           id="phone"
                           value="{{ old('phone', $patient->phone) }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200"
                           placeholder="+1234567890">
                </div>

                <!-- Blood Group -->
                <div>
                    <label for="blood_group" class="block text-sm font-medium text-gray-700 mb-2">Blood Group</label>
                    <select name="blood_group" 
                            id="blood_group"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200">
                        <option value="">Select Blood Group</option>
                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                            <option value="{{ $bg }}" {{ old('blood_group', $patient->blood_group) === $bg ? 'selected' : '' }}>{{ $bg }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Height -->
                <div>
                    <label for="height" class="block text-sm font-medium text-gray-700 mb-2">Height (cm)</label>
                    <input type="number" 
                           name="height" 
                           id="height"
                           step="0.01"
                           value="{{ old('height', $patient->height) }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200"
                           placeholder="175.0">
                </div>

                <!-- Weight -->
                <div>
                    <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Weight (kg)</label>
                    <input type="number" 
                           name="weight" 
                           id="weight"
                           step="0.01"
                           value="{{ old('weight', $patient->weight) }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200"
                           placeholder="70.0">
                </div>

                <!-- BMI (read-only) -->
                @if($patient->bmi)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">BMI</label>
                    <input type="text" 
                           value="{{ number_format($patient->bmi, 2) }}" 
                           disabled
                           class="w-full border-gray-300 rounded-md shadow-sm bg-gray-50">
                    <p class="text-xs text-gray-500 mt-1">Calculated automatically from height and weight</p>
                </div>
                @endif
            </div>

            <!-- Address -->
            <div class="mt-6">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                <textarea name="address" 
                          id="address"
                          rows="3"
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200"
                          placeholder="Enter your complete address">{{ old('address', $patient->address) }}</textarea>
            </div>

            <!-- Medical History -->
            <div class="mt-6">
                <label for="medical_history" class="block text-sm font-medium text-gray-700 mb-2">Medical History</label>
                <textarea name="medical_history" 
                          id="medical_history"
                          rows="4"
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200"
                          placeholder="List any pre-existing conditions, allergies, medications, or relevant medical history...">{{ old('medical_history', $patient->medical_history) }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="mt-8">
                <button type="submit" 
                        class="w-full bg-[#40C9A2] text-white px-6 py-3 rounded-xl font-semibold hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
