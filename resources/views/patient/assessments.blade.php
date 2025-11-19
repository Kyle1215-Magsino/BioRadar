@extends('layouts.app')

@section('title', 'My Assessments')

@section('content')
<div class="max-w-7xl mx-auto animate__animated animate__fadeIn">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-[#1B9AAA]">My Assessments</h1>
        <a href="{{ route('patient.assessment.create') }}" class="bg-[#40C9A2] text-white px-6 py-3 rounded-xl font-semibold hover:shadow-xl transform hover:-translate-y-1 transition duration-300 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Assessment
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 border border-[#D3F9D8]">
        <form method="GET" action="{{ route('patient.assessments') }}" class="flex flex-wrap gap-4">
            <div class="min-w-[200px]">
                <select name="status" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="min-w-[200px]">
                <select name="type" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200">
                    <option value="">All Types</option>
                    <option value="automated" {{ request('type') === 'automated' ? 'selected' : '' }}>Automated</option>
                    <option value="doctor-review" {{ request('type') === 'doctor-review' ? 'selected' : '' }}>Doctor Review</option>
                </select>
            </div>
            <button type="submit" class="bg-[#40C9A2] text-white px-6 py-2 rounded-xl font-semibold hover:shadow-lg transition duration-300">
                Filter
            </button>
            <a href="{{ route('patient.assessments') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-xl font-semibold hover:bg-gray-300 transition duration-300">
                Reset
            </a>
        </form>
    </div>

    <!-- Assessments Grid -->
    <div class="grid grid-cols-1 gap-6">
        @forelse($assessments as $assessment)
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-[#D3F9D8] hover:shadow-xl transition duration-300">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-xl font-semibold text-[#1B9AAA] mb-2">
                        Assessment #{{ $assessment->id }}
                    </h3>
                    <p class="text-sm text-gray-600">
                        Submitted: {{ $assessment->submitted_at->format('F d, Y \a\t h:i A') }}
                    </p>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full mb-2
                        @if($assessment->status === 'completed') bg-[#D3F9D8] text-[#1B9AAA]
                        @elseif($assessment->status === 'in_progress') bg-yellow-100 text-yellow-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($assessment->status) }}
                    </span>
                    <p class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $assessment->assessment_type)) }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="bg-[#D3F9D8] rounded-xl p-4">
                    <p class="text-xs text-gray-600 mb-1">Symptoms Reported</p>
                    <p class="text-2xl font-bold text-[#1B9AAA]">{{ $assessment->symptoms->count() }}</p>
                </div>

                @if($assessment->riskEvaluation)
                <div class="bg-[#40C9A2] rounded-xl p-4 text-white">
                    <p class="text-xs opacity-90 mb-1">Risk Level</p>
                    <p class="text-2xl font-bold">{{ ucfirst($assessment->riskEvaluation->risk_level) }}</p>
                </div>

                <div class="bg-[#40C9A2] rounded-xl p-4 text-white">
                    <p class="text-xs opacity-90 mb-1">Risk Score</p>
                    <p class="text-2xl font-bold">{{ number_format($assessment->riskEvaluation->risk_percentage, 1) }}%</p>
                </div>
                @else
                <div class="col-span-2 bg-[#40C9A2] rounded-xl p-4 flex items-center justify-center text-white">
                    <p class="text-sm font-medium">⏳ Evaluation Pending</p>
                </div>
                @endif
            </div>

            @if($assessment->doctor)
            <div class="mb-4 text-sm text-gray-600">
                <span class="font-medium">Reviewed by:</span> {{ $assessment->doctor->user->name }}
            </div>
            @endif

            <div class="flex justify-end">
                <a href="{{ route('patient.assessment.result', $assessment) }}" 
                   class="bg-[#40C9A2] text-white px-6 py-2 rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
                    View Details
                </a>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center border border-[#D3F9D8]">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No assessments yet</h3>
            <p class="mt-2 text-gray-500">Get started by creating your first health assessment.</p>
            <div class="mt-6">
                <a href="{{ route('patient.assessment.create') }}" 
                   class="inline-flex items-center bg-[#40C9A2] text-white px-6 py-3 rounded-xl font-semibold hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                    Create Assessment
                </a>
            </div>
        </div>
        @endforelse
    </div>

    @if($assessments->hasPages())
    <div class="mt-6">
        {{ $assessments->links() }}
    </div>
    @endif
</div>
@endsection
