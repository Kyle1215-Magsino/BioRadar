@extends('layouts.app')

@section('title', 'View Assessment')

@section('content')
<div class="max-w-5xl mx-auto animate__animated animate__fadeIn">
    <div class="mb-6">
        <a href="{{ route('admin.assessments') }}" class="text-[#1B9AAA] hover:text-[#40C9A2] flex items-center font-semibold transition duration-200">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Assessments
        </a>
    </div>

    <!-- Assessment Overview -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-6 border border-[#D3F9D8]">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h1 class="text-3xl font-bold text-[#1B9AAA] mb-2">
                    Assessment #{{ $assessment->id }}
                </h1>
                <p class="text-gray-600">Submitted: {{ $assessment->submitted_at->format('F d, Y \a\t h:i A') }}</p>
            </div>
            <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full 
                @if($assessment->status === 'completed') bg-[#D3F9D8] text-[#1B9AAA]
                @elseif($assessment->status === 'in_progress') bg-yellow-100 text-yellow-800
                @else bg-gray-100 text-gray-800
                @endif">
                {{ ucfirst($assessment->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-[#D3F9D8] rounded-xl p-4">
                <p class="text-sm text-gray-600 mb-1">Assessment Type</p>
                <p class="text-lg font-semibold text-[#1B9AAA]">{{ ucfirst(str_replace('_', ' ', $assessment->assessment_type)) }}</p>
            </div>
            <div class="bg-[#40C9A2] rounded-xl p-4 text-white">
                <p class="text-sm opacity-90 mb-1">Symptoms Reported</p>
                <p class="text-lg font-semibold">{{ $assessment->symptoms->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Patient Information -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-6 border border-[#D3F9D8]">
        <h2 class="text-2xl font-bold text-[#1B9AAA] mb-4">Patient Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-sm text-gray-600 mb-1">Name</p>
                <p class="font-semibold text-gray-900">{{ $assessment->patient->user->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Email</p>
                <p class="font-semibold text-gray-900">{{ $assessment->patient->user->email }}</p>
            </div>
            @if($assessment->patient->age)
            <div>
                <p class="text-sm text-gray-600 mb-1">Age</p>
                <p class="font-semibold text-gray-900">{{ $assessment->patient->age }} years</p>
            </div>
            @endif
            @if($assessment->patient->gender)
            <div>
                <p class="text-sm text-gray-600 mb-1">Gender</p>
                <p class="font-semibold text-gray-900">{{ ucfirst($assessment->patient->gender) }}</p>
            </div>
            @endif
            @if($assessment->patient->blood_group)
            <div>
                <p class="text-sm text-gray-600 mb-1">Blood Group</p>
                <p class="font-semibold text-gray-900">{{ $assessment->patient->blood_group }}</p>
            </div>
            @endif
            @if($assessment->patient->bmi)
            <div>
                <p class="text-sm text-gray-600 mb-1">BMI</p>
                <p class="font-semibold text-gray-900">{{ number_format($assessment->patient->bmi, 2) }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Risk Evaluation -->
    @if($assessment->riskEvaluation)
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-6 border border-[#D3F9D8]">
        <h2 class="text-2xl font-bold text-[#1B9AAA] mb-4">Risk Evaluation</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-[#D3F9D8] rounded-2xl p-6 text-center">
                <p class="text-sm text-gray-600 mb-2">Risk Level</p>
                <p class="text-4xl font-bold 
                    @if($assessment->riskEvaluation->risk_level === 'low') text-[#40C9A2]
                    @elseif($assessment->riskEvaluation->risk_level === 'moderate') text-yellow-600
                    @elseif($assessment->riskEvaluation->risk_level === 'high') text-orange-600
                    @else text-red-600
                    @endif">
                    {{ ucfirst($assessment->riskEvaluation->risk_level) }}
                </p>
            </div>

            <div class="bg-[#40C9A2] rounded-2xl p-6 text-center text-white">
                <p class="text-sm opacity-90 mb-2">Risk Score</p>
                <p class="text-4xl font-bold">{{ number_format($assessment->riskEvaluation->risk_percentage, 1) }}%</p>
            </div>

            @if($assessment->doctor)
            <div class="bg-[#40C9A2] rounded-2xl p-6 text-white">
                <p class="text-sm opacity-90 mb-2">Evaluated By</p>
                <p class="text-lg font-semibold">{{ $assessment->doctor->user->name }}</p>
                <p class="text-xs opacity-80">{{ $assessment->doctor->specialization ?? 'Doctor' }}</p>
            </div>
            @endif
        </div>

        @if($assessment->riskEvaluation->evaluation_notes)
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-[#1B9AAA] mb-2">Evaluation Notes</h3>
            <div class="bg-[#B2F2BB] rounded-xl p-4">
                <p class="text-gray-800 whitespace-pre-line">{{ $assessment->riskEvaluation->evaluation_notes }}</p>
            </div>
        </div>
        @endif

        @if($assessment->riskEvaluation->recommendations)
        <div>
            <h3 class="text-lg font-semibold text-[#1B9AAA] mb-2">Recommendations</h3>
            <div class="bg-[#B2F2BB] rounded-xl p-4">
                <p class="text-gray-800 whitespace-pre-line">{{ $assessment->riskEvaluation->recommendations }}</p>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- Symptoms -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-6 border border-[#D3F9D8]">
        <h2 class="text-2xl font-bold text-[#1B9AAA] mb-4">Reported Symptoms</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($assessment->symptoms as $symptom)
            <div class="border border-[#D3F9D8] rounded-xl p-4 hover:bg-[#D3F9D8] transition duration-200">
                <h4 class="font-semibold text-[#1B9AAA] mb-2">{{ $symptom->name }}</h4>
                @if($symptom->description)
                <p class="text-sm text-gray-600 mb-3">{{ $symptom->description }}</p>
                @endif
                <div class="flex gap-4 text-sm">
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
                        <span class="font-medium text-[#1B9AAA]">{{ $symptom->pivot->duration_days }} days</span>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <p class="text-gray-500">No symptoms reported.</p>
            @endforelse
        </div>
    </div>

    <!-- Additional Notes -->
    @if($assessment->additional_notes)
    <div class="bg-white rounded-2xl shadow-xl p-6 border border-[#D3F9D8]">
        <h2 class="text-2xl font-bold text-[#1B9AAA] mb-4">Additional Notes</h2>
        <p class="text-gray-700 whitespace-pre-line">{{ $assessment->additional_notes }}</p>
    </div>
    @endif
</div>
@endsection
