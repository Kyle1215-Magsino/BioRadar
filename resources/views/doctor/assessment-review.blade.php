@extends('layouts.app')

@section('title', 'Review Assessment')

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
<div class="max-w-5xl mx-auto animate__animated animate__fadeIn">
    <div class="mb-6">
        <a href="{{ route('doctor.assessments') }}" class="text-[#1B9AAA] hover:text-[#40C9A2] flex items-center font-semibold transition duration-200">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Assessments
        </a>
    </div>

    <!-- Patient Information -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-6 border border-[#D3F9D8]">
        <h2 class="text-2xl font-bold text-[#1B9AAA] mb-4">Patient Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-medium text-gray-600 mb-1">Name</h3>
                <p class="text-lg text-gray-900">{{ $assessment->patient->user->name }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-600 mb-1">Email</h3>
                <p class="text-lg text-gray-900">{{ $assessment->patient->user->email }}</p>
            </div>
            @if($assessment->patient->date_of_birth)
            <div>
                <h3 class="text-sm font-medium text-gray-600 mb-1">Age</h3>
                <p class="text-lg text-gray-900">{{ $assessment->patient->age }} years</p>
            </div>
            @endif
            @if($assessment->patient->gender)
            <div>
                <h3 class="text-sm font-medium text-gray-600 mb-1">Gender</h3>
                <p class="text-lg text-gray-900">{{ ucfirst($assessment->patient->gender) }}</p>
            </div>
            @endif
            @if($assessment->patient->bmi)
            <div>
                <h3 class="text-sm font-medium text-gray-600 mb-1">BMI</h3>
                <p class="text-lg text-gray-900">{{ number_format($assessment->patient->bmi, 2) }}</p>
            </div>
            @endif
            @if($assessment->patient->blood_group)
            <div>
                <h3 class="text-sm font-medium text-gray-600 mb-1">Blood Group</h3>
                <p class="text-lg text-gray-900">{{ $assessment->patient->blood_group }}</p>
            </div>
            @endif
        </div>
        @if($assessment->patient->medical_history)
        <div class="mt-4 pt-4 border-t">
            <h3 class="text-sm font-medium text-gray-600 mb-2">Medical History</h3>
            <p class="text-gray-800 whitespace-pre-line">{{ $assessment->patient->medical_history }}</p>
        </div>
        @endif
    </div>

    <!-- Assessment Details -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex justify-between items-start mb-4">
            <h2 class="text-2xl font-bold text-gray-900">Assessment Details</h2>
            <div class="text-right">
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                    @if($assessment->status === 'completed') bg-[#D3F9D8] text-[#1B9AAA]
                    @elseif($assessment->status === 'in_progress') bg-yellow-100 text-yellow-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($assessment->status) }}
                </span>
            </div>
        </div>

        <div class="mb-4">
            <h3 class="text-sm font-medium text-gray-600 mb-1">Submitted</h3>
            <p class="text-gray-900">{{ $assessment->submitted_at->format('F d, Y \a\t h:i A') }}</p>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Reported Symptoms</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($assessment->symptoms as $symptom)
                <div class="border rounded-lg p-4 bg-gray-50">
                    <h4 class="font-semibold text-gray-900">{{ $symptom->name }}</h4>
                    <p class="text-sm text-gray-600 mt-1">{{ $symptom->description }}</p>
                    <p class="text-xs text-gray-500 mt-2">Category: {{ $symptom->category }} | Risk Weight: {{ $symptom->risk_weight }}</p>
                    
                    @if($symptom->pivot->severity || $symptom->pivot->duration_days)
                    <div class="mt-3 pt-3 border-t flex gap-4 text-sm">
                        @if($symptom->pivot->severity)
                        <div>
                            <span class="text-gray-600">Severity:</span>
                            <span class="font-medium 
                                @if($symptom->pivot->severity === 'severe') text-red-600
                                @elseif($symptom->pivot->severity === 'moderate') text-yellow-600
                                @else text-[#40C9A2]
                                @endif">
                                {{ ucfirst($symptom->pivot->severity) }}
                            </span>
                        </div>
                        @endif
                        
                        @if($symptom->pivot->duration_days)
                        <div>
                            <span class="text-gray-600">Duration:</span>
                            <span class="font-medium text-gray-900">{{ $symptom->pivot->duration_days }} days</span>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        @if($assessment->additional_notes)
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Additional Notes from Patient</h3>
            <div class="bg-[#D3F9D8] border-l-4 border-[#40C9A2] p-4">
                <p class="text-gray-800 whitespace-pre-line">{{ $assessment->additional_notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Claim Assessment (if not claimed) -->
    @if(!$assessment->doctor_id)
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 mb-6 rounded-lg">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-yellow-800">This assessment is unassigned</h3>
                <p class="text-yellow-700 mt-1">Claim this assessment to start your evaluation.</p>
            </div>
            <form method="POST" action="{{ route('doctor.assessment.claim', $assessment) }}">
                @csrf
                <button type="submit" class="bg-yellow-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-yellow-700 transition">
                    Claim Assessment
                </button>
            </form>
        </div>
    </div>
    @endif

    <!-- Risk Evaluation Form -->
    @if($assessment->doctor_id === auth()->user()->doctor->id)
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Submit Risk Evaluation</h2>

        @if($assessment->riskEvaluation)
        <div class="mb-6 p-4 bg-[#D3F9D8] rounded-lg">
            <p class="text-[#1B9AAA] font-semibold">This assessment has already been evaluated.</p>
            <p class="text-[#1B9AAA] text-sm mt-1">You can update the evaluation by submitting a new one below.</p>
        </div>
        @endif

        <form method="POST" action="{{ route('doctor.assessment.evaluate', $assessment) }}">
            @csrf

            <!-- Risk Percentage -->
            <div class="mb-6">
                <label for="risk_percentage" class="block text-sm font-medium text-gray-700 mb-2">
                    Risk Percentage (0-100) <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       name="risk_percentage" 
                       id="risk_percentage"
                       min="0"
                       max="100"
                       step="0.01"
                       value="{{ old('risk_percentage', $assessment->riskEvaluation->risk_percentage ?? '') }}"
                       required
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500"
                       placeholder="e.g., 35.5">
                <p class="text-xs text-gray-500 mt-1">Risk levels: 0-24% (Low), 25-49% (Moderate), 50-74% (High), 75-100% (Critical)</p>
            </div>

            <!-- Evaluation Notes -->
            <div class="mb-6">
                <label for="evaluation_notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Evaluation Notes <span class="text-red-500">*</span>
                </label>
                <textarea name="evaluation_notes" 
                          id="evaluation_notes"
                          rows="6"
                          required
                          class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500"
                          placeholder="Provide detailed evaluation of the patient's symptoms and risk factors...">{{ old('evaluation_notes', $assessment->riskEvaluation->evaluation_notes ?? '') }}</textarea>
            </div>

            <!-- Recommendations -->
            <div class="mb-6">
                <label for="recommendations" class="block text-sm font-medium text-gray-700 mb-2">
                    Recommendations <span class="text-red-500">*</span>
                </label>
                <textarea name="recommendations" 
                          id="recommendations"
                          rows="6"
                          required
                          class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500"
                          placeholder="Provide specific recommendations for the patient...">{{ old('recommendations', $assessment->riskEvaluation->recommendations ?? '') }}</textarea>
            </div>

            <!-- Send Email -->
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="send_email" 
                           value="1"
                           checked
                           class="h-4 w-4 text-[#40C9A2] focus:ring-[#40C9A2] border-gray-300 rounded">
                    <span class="ml-2 text-sm text-gray-700">Send evaluation results to patient via email</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-4">
                <button type="submit" 
                        class="flex-1 bg-[#40C9A2] text-white px-6 py-3 rounded-lg font-semibold hover:shadow-xl transition">
                    Submit Evaluation
                </button>
                <a href="{{ route('doctor.assessments') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection
