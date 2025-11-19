@extends('layouts.app')

@section('title', 'Pending Assessments')

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
<div class="max-w-7xl mx-auto animate__animated animate__fadeIn">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-[#1B9AAA]">Pending Assessments</h1>
        <div class="bg-[#40C9A2] text-white px-6 py-3 rounded-xl font-semibold shadow-lg">
            {{ $pendingCount ?? $assessments->total() }} Pending
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-[#D3F9D8]">
            <div class="flex items-center">
                <div class="bg-[#40C9A2] rounded-xl p-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <h3 class="text-gray-600 text-sm font-medium">Awaiting Review</h3>
                    <p class="text-3xl font-bold text-[#1B9AAA]">
                        {{ $pendingCount ?? $assessments->total() }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-[#D3F9D8]">
            <div class="flex items-center">
                <div class="bg-[#40C9A2] rounded-xl p-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <h3 class="text-gray-600 text-sm font-medium">Unique Patients</h3>
                    <p class="text-3xl font-bold text-[#40C9A2]">
                        {{ $uniquePatientsCount ?? 0 }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Assessments Cards -->
    <div class="grid grid-cols-1 gap-6">
        @forelse($assessments as $assessment)
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-[#40C9A2] hover:shadow-xl transition duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="bg-[#40C9A2] rounded-full w-12 h-12 flex items-center justify-center text-white font-bold text-lg">
                            {{ strtoupper(substr($assessment->patient->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-[#1B9AAA]">
                                {{ $assessment->patient->user->name }}
                            </h3>
                            <p class="text-sm text-gray-600">{{ $assessment->patient->user->email }}</p>
                        </div>
                    </div>
                    
                    <div class="ml-15 grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                        <div>
                            <p class="text-xs text-gray-600">Assessment ID</p>
                            <p class="font-semibold text-[#1B9AAA]">#{{ $assessment->id }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Submitted</p>
                            <p class="font-semibold text-gray-900">{{ $assessment->submitted_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Type</p>
                            <p class="font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $assessment->assessment_type)) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Symptoms</p>
                            <p class="font-semibold text-gray-900">{{ $assessment->symptoms->count() }} reported</p>
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 mb-3">
                        Pending Review
                    </span>
                </div>
            </div>

            <!-- Patient Info Preview -->
            @if($assessment->patient->age || $assessment->patient->gender)
            <div class="bg-[#D3F9D8] rounded-xl p-4 mb-4">
                <p class="text-xs font-medium text-gray-600 mb-2">Patient Information</p>
                <div class="flex gap-6 text-sm">
                    @if($assessment->patient->age)
                    <div>
                        <span class="text-gray-600">Age:</span>
                        <span class="font-semibold text-gray-900 ml-1">{{ $assessment->patient->age }} years</span>
                    </div>
                    @endif
                    @if($assessment->patient->gender)
                    <div>
                        <span class="text-gray-600">Gender:</span>
                        <span class="font-semibold text-gray-900 ml-1">{{ ucfirst($assessment->patient->gender) }}</span>
                    </div>
                    @endif
                    @if($assessment->patient->blood_group)
                    <div>
                        <span class="text-gray-600">Blood Group:</span>
                        <span class="font-semibold text-gray-900 ml-1">{{ $assessment->patient->blood_group }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Symptoms Preview -->
            <div class="mb-4">
                <p class="text-xs font-medium text-gray-600 mb-2">Reported Symptoms ({{ $assessment->symptoms->count() }})</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($assessment->symptoms->take(5) as $symptom)
                    <span class="px-3 py-1 bg-[#B2F2BB] text-gray-700 rounded-full text-xs font-medium">
                        {{ $symptom->name }}
                    </span>
                    @endforeach
                    @if($assessment->symptoms->count() > 5)
                    <span class="px-3 py-1 bg-gray-200 text-gray-700 rounded-full text-xs font-medium">
                        +{{ $assessment->symptoms->count() - 5 }} more
                    </span>
                    @endif
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('doctor.assessment.review', $assessment) }}" 
                   class="bg-[#40C9A2] text-white px-6 py-3 rounded-xl font-semibold hover:shadow-xl transform hover:-translate-y-1 transition duration-300 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Review Assessment
                </a>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center border border-[#D3F9D8]">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">All caught up!</h3>
            <p class="mt-2 text-gray-500">There are no pending assessments at the moment.</p>
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
