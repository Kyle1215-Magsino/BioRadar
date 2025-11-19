@extends('layouts.app')

@section('title', 'Patient Dashboard')

@section('content')
<div class="max-w-7xl mx-auto animate__animated animate__fadeIn">
    <h1 class="text-3xl font-bold text-[#1B9AAA] mb-8">Welcome, {{ auth()->user()->name }}</h1>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="stat-card bg-white rounded-2xl shadow-lg p-6 transform hover:-translate-y-2 transition duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-[#40C9A2] rounded-xl p-3 shadow-md">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <h3 class="text-gray-500 text-sm font-medium">Total Assessments</h3>
                    <p class="text-3xl font-semibold text-[#1B9AAA]">{{ $stats['total_assessments'] }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl shadow-lg p-6 transform hover:-translate-y-2 transition duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-[#40C9A2] rounded-xl p-3 shadow-md">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <h3 class="text-gray-500 text-sm font-medium">Pending</h3>
                    <p class="text-3xl font-semibold text-[#40C9A2]">{{ $stats['pending_assessments'] }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl shadow-lg p-6 transform hover:-translate-y-2 transition duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-[#B2F2BB] rounded-xl p-3 shadow-md">
                    <svg class="h-6 w-6 text-[#1B9AAA]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <h3 class="text-gray-500 text-sm font-medium">Completed</h3>
                    <p class="text-3xl font-semibold text-[#40C9A2]">{{ $stats['completed_assessments'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-[#D3F9D8]">
        <h2 class="text-xl font-semibold text-[#1B9AAA] mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('patient.assessment.create') }}" class="flex items-center p-4 bg-[#D3F9D8] rounded-xl hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
                <svg class="h-8 w-8 text-[#1B9AAA]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <div class="ml-4">
                    <h3 class="font-semibold text-[#1B9AAA]">New Assessment</h3>
                    <p class="text-sm text-gray-600">Submit symptoms for evaluation</p>
                </div>
            </a>
            <a href="{{ route('patient.profile') }}" class="flex items-center p-4 bg-[#40C9A2] rounded-xl hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <div class="ml-4">
                    <h3 class="font-semibold text-white">Update Profile</h3>
                    <p class="text-sm text-white opacity-90">Manage your health information</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Assessments -->
    <div class="bg-white rounded-2xl shadow-lg border border-[#D3F9D8]">
        <div class="px-6 py-4 border-b border-[#D3F9D8] bg-[#D3F9D8]">
            <h2 class="text-xl font-semibold text-[#1B9AAA]">Recent Assessments</h2>
        </div>
        <div class="overflow-x-auto">
            @if($recentAssessments->count() > 0)
                <table class="min-w-full divide-y divide-[#D3F9D8]">
                    <thead class="bg-[#B2F2BB]">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#1B9AAA] uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#1B9AAA] uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#1B9AAA] uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#1B9AAA] uppercase tracking-wider">Risk Level</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#1B9AAA] uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-[#D3F9D8]">
                        @foreach($recentAssessments as $assessment)
                        <tr class="hover:bg-[#D3F9D8] transition duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $assessment->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ ucfirst(str_replace('_', ' ', $assessment->assessment_type)) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($assessment->status === 'completed') bg-[#D3F9D8] text-[#1B9AAA]
                                    @elseif($assessment->status === 'in_progress') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($assessment->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($assessment->riskEvaluation)
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($assessment->riskEvaluation->risk_level === 'low') bg-[#D3F9D8] text-[#1B9AAA]
                                        @elseif($assessment->riskEvaluation->risk_level === 'moderate') bg-yellow-100 text-yellow-800
                                        @elseif($assessment->riskEvaluation->risk_level === 'high') bg-orange-100 text-orange-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($assessment->riskEvaluation->risk_level) }} ({{ number_format($assessment->riskEvaluation->risk_percentage, 1) }}%)
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('patient.assessment.result', $assessment) }}" class="text-[#1B9AAA] hover:text-[#40C9A2] font-semibold transition duration-200">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No assessments</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new assessment.</p>
                    <div class="mt-6">
                        <a href="{{ route('patient.assessment.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-lg text-sm font-medium rounded-xl text-white bg-gradient-to-r from-[#40C9A2] to-[#1B9AAA] hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                            New Assessment
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
