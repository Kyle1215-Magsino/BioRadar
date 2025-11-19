@extends('layouts.app')

@section('title', 'New Health Assessment')

@push('scripts')
<script>
$(document).ready(function() {
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#ef4444'
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: '<ul class="text-left">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
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
        <h1 class="text-3xl font-bold text-[#1B9AAA] mb-6">New Health Assessment</h1>
        
        <div class="mb-8 p-4 bg-[#B2F2BB] rounded-xl border-l-4 border-[#40C9A2]">
            <h3 class="font-semibold text-[#1B9AAA] mb-2">Choose Assessment Type:</h3>
            <p class="text-gray-700 text-sm mb-3">
                <strong>Automated Assessment:</strong> Get instant risk evaluation based on your symptoms.<br>
                <strong>Doctor Review:</strong> Request professional evaluation from a qualified doctor.
            </p>
        </div>

        <form id="assessment-form">
            @csrf
            
            <!-- Symptoms Selection -->
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-[#1B9AAA] mb-4">Select Your Symptoms</h2>
                
                @php
                    $groupedSymptoms = $symptoms->groupBy('category');
                @endphp

                @foreach($groupedSymptoms as $category => $categorySymptoms)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-[#1B9AAA] mb-3 pb-2 border-b border-[#D3F9D8]">{{ $category ?? 'Other' }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($categorySymptoms as $symptom)
                        <div class="border border-[#D3F9D8] rounded-xl p-4 hover:bg-[#D3F9D8] hover:shadow-md transition duration-200">
                            <div class="flex items-start">
                                <input type="checkbox" 
                                       name="symptoms[]" 
                                       value="{{ $symptom->id }}" 
                                       id="symptom_{{ $symptom->id }}"
                                       class="mt-1 h-4 w-4 text-[#40C9A2] focus:ring-[#40C9A2] border-gray-300 rounded"
                                       onchange="toggleSymptomDetails({{ $symptom->id }})">
                                <label for="symptom_{{ $symptom->id }}" class="ml-3 flex-1 cursor-pointer">
                                    <span class="font-medium text-gray-900">{{ $symptom->name }}</span>
                                    @if($symptom->description)
                                        <p class="text-sm text-gray-600 mt-1">{{ $symptom->description }}</p>
                                    @endif
                                </label>
                            </div>
                            
                            <div id="details_{{ $symptom->id }}" class="mt-3 ml-7 hidden space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Severity</label>
                                    <select name="severity[{{ $symptom->id }}]" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200">
                                        <option value="mild">Mild</option>
                                        <option value="moderate">Moderate</option>
                                        <option value="severe">Severe</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Duration (days)</label>
                                    <input type="number" 
                                           name="duration_days[{{ $symptom->id }}]" 
                                           min="1" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200"
                                           placeholder="e.g., 7">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Additional Notes -->
            <div class="mb-8">
                <label for="additional_notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Additional Notes (Optional)
                </label>
                <textarea name="additional_notes" 
                          id="additional_notes" 
                          rows="4" 
                          class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200"
                          placeholder="Provide any additional information about your symptoms or health concerns..."></textarea>
            </div>

            <!-- Submit Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <button type="button" 
                        onclick="submitAssessment('automated')"
                        class="flex-1 bg-[#40C9A2] text-white px-6 py-3 rounded-xl font-semibold hover:shadow-xl transform hover:-translate-y-1 transition duration-300 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Get Instant Assessment
                </button>
                <button type="button" 
                        onclick="submitAssessment('doctor-review')"
                        class="flex-1 bg-[#40C9A2] text-white px-6 py-3 rounded-xl font-semibold hover:shadow-xl transform hover:-translate-y-1 transition duration-300 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Request Doctor Review
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function toggleSymptomDetails(symptomId) {
    const checkbox = document.getElementById('symptom_' + symptomId);
    const details = document.getElementById('details_' + symptomId);
    
    if (checkbox.checked) {
        details.classList.remove('hidden');
    } else {
        details.classList.add('hidden');
    }
}

function submitAssessment(type) {
    const form = document.getElementById('assessment-form');
    const formData = new FormData(form);
    
    // Check if at least one symptom is selected
    const checkedSymptoms = document.querySelectorAll('input[name="symptoms[]"]:checked');
    if (checkedSymptoms.length === 0) {
        alert('Please select at least one symptom.');
        return;
    }
    
    // Set the action URL based on type
    const actionUrl = type === 'automated' 
        ? '{{ route("patient.assessment.automated") }}' 
        : '{{ route("patient.assessment.doctor-review") }}';
    
    form.action = actionUrl;
    form.method = 'POST';
    form.submit();
}
</script>
@endpush
@endsection
