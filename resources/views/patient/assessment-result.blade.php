@extends('layouts.app')

@section('title', 'Assessment Result')

@section('content')
<div class="max-w-5xl mx-auto animate__animated animate__fadeIn">
    <div class="mb-6">
        <a href="{{ route('patient.assessments') }}" class="text-[#1B9AAA] hover:text-[#40C9A2] flex items-center font-semibold transition duration-200">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Assessments
        </a>
    </div>

    <!-- Assessment Header -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-6 border border-[#D3F9D8]">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-[#1B9AAA] mb-2">Assessment Details</h1>
                <p class="text-gray-600">Submitted on {{ $assessment->submitted_at->format('F d, Y \a\t h:i A') }}</p>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                    @if($assessment->status === 'completed') bg-[#D3F9D8] text-[#1B9AAA]
                    @elseif($assessment->status === 'in_progress') bg-yellow-100 text-yellow-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($assessment->status) }}
                </span>
                <p class="text-sm text-gray-600 mt-2">{{ ucfirst(str_replace('_', ' ', $assessment->assessment_type)) }}</p>
            </div>
        </div>
    </div>

    <!-- Risk Evaluation -->
    @if($assessment->riskEvaluation)
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-6 border border-[#D3F9D8]">
        <h2 class="text-2xl font-bold text-[#1B9AAA] mb-4">Risk Evaluation</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-[#D3F9D8] rounded-2xl p-6 shadow-md">
                <h3 class="text-sm font-medium text-[#1B9AAA] mb-2">Risk Level</h3>
                <div class="flex items-center">
                    <span class="text-4xl font-bold 
                        @if($assessment->riskEvaluation->risk_level === 'low') text-[#40C9A2]
                        @elseif($assessment->riskEvaluation->risk_level === 'moderate') text-yellow-600
                        @elseif($assessment->riskEvaluation->risk_level === 'high') text-orange-600
                        @else text-red-600
                        @endif">
                        {{ ucfirst($assessment->riskEvaluation->risk_level) }}
                    </span>
                    <div class="ml-4">
                        <div class="text-3xl font-bold text-[#1B9AAA]">{{ number_format($assessment->riskEvaluation->risk_percentage, 1) }}%</div>
                        <div class="text-sm text-gray-600">Risk Score</div>
                    </div>
                </div>
            </div>

            @if($assessment->doctor)
            <div class="bg-[#40C9A2] rounded-2xl p-6 shadow-md text-white">
                <h3 class="text-sm font-medium mb-2">Evaluated By</h3>
                <p class="text-xl font-semibold">{{ $assessment->doctor->user->name }}</p>
                <p class="text-sm opacity-90">{{ $assessment->doctor->specialization ?? 'Medical Doctor' }}</p>
                @if($assessment->completed_at)
                    <p class="text-xs opacity-80 mt-2">{{ $assessment->completed_at->format('F d, Y') }}</p>
                @endif
            </div>
            @endif
        </div>

        @if($assessment->riskEvaluation->evaluation_notes)
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-[#1B9AAA] mb-3">Evaluation Notes</h3>
            <div class="bg-[#B2F2BB] border-l-4 border-[#40C9A2] rounded-r-xl p-4">
                <p class="text-gray-800 whitespace-pre-line">{{ $assessment->riskEvaluation->evaluation_notes }}</p>
            </div>
        </div>
        @endif

        @if($assessment->riskEvaluation->recommendations)
        <div>
            <h3 class="text-lg font-semibold text-[#1B9AAA] mb-3">Recommendations</h3>
            <div class="bg-[#B2F2BB] border-l-4 border-[#40C9A2] rounded-r-xl p-4">
                <p class="text-gray-800 whitespace-pre-line">{{ $assessment->riskEvaluation->recommendations }}</p>
            </div>
        </div>
        @endif

        @if($assessment->riskEvaluation->email_sent)
        <div class="mt-4 p-3 bg-[#D3F9D8] rounded-xl flex items-center text-sm text-gray-700 border border-[#B2F2BB]">
            <svg class="w-5 h-5 mr-2 text-[#40C9A2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            Report sent to your email on {{ $assessment->riskEvaluation->email_sent_at->format('F d, Y \a\t h:i A') }}
        </div>
        @endif
    </div>
    @elseif($assessment->status === 'pending')
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 mb-6 rounded-2xl shadow-md">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-lg font-semibold text-yellow-800">Waiting for Doctor Review</h3>
                <p class="text-yellow-700 mt-2">Your assessment is pending review by a doctor. You will receive an email notification once the evaluation is complete.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Symptoms -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-6 border border-[#D3F9D8]">
        <h2 class="text-2xl font-bold text-[#1B9AAA] mb-4">Reported Symptoms</h2>
        
        @if($assessment->symptoms->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($assessment->symptoms as $symptom)
                <div class="border border-[#D3F9D8] rounded-xl p-4 hover:bg-[#D3F9D8] transition duration-200">
                    <h4 class="font-semibold text-[#1B9AAA]">{{ $symptom->name }}</h4>
                    @if($symptom->description)
                        <p class="text-sm text-gray-600 mt-1">{{ $symptom->description }}</p>
                    @endif
                    
                    <div class="mt-3 flex gap-4 text-sm">
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
                @endforeach
            </div>
        @else
            <p class="text-gray-600">No symptoms recorded.</p>
        @endif
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
