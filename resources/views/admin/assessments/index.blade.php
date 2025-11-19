@extends('layouts.app')

@section('title', 'All Assessments')

@section('content')
<div class="max-w-7xl mx-auto animate__animated animate__fadeIn">
    <h1 class="text-3xl font-bold text-[#1B9AAA] mb-6">All Assessments</h1>

    <!-- Assessments Table -->
    <div class="bg-white rounded-2xl shadow-xl border border-[#D3F9D8] overflow-hidden">
        <div class="overflow-x-auto p-4">
            <table id="assessmentsTable" class="min-w-full divide-y divide-[#D3F9D8] display responsive nowrap" style="width:100%">
                <thead class="bg-[#B2F2BB]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#1B9AAA] uppercase tracking-wider">Patient</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#1B9AAA] uppercase tracking-wider">Submitted</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#1B9AAA] uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#1B9AAA] uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#1B9AAA] uppercase tracking-wider">Risk Level</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#1B9AAA] uppercase tracking-wider">Doctor</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-[#D3F9D8]">
                    @foreach($assessments as $assessment)
                    <tr class="hover:bg-[#D3F9D8] transition duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $assessment->patient->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $assessment->patient->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $assessment->submitted_at->format('M d, Y') }}
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
                                    {{ ucfirst($assessment->riskEvaluation->risk_level) }}
                                </span>
                            @else
                                <span class="text-sm text-gray-500">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $assessment->doctor ? $assessment->doctor->user->name : '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('styles')
<style>
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #D3F9D8;
        border-radius: 0.75rem;
        padding: 0.5rem 1rem;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(to right, #40C9A2, #1B9AAA) !important;
        color: white !important;
        border-radius: 0.5rem;
        border: none !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #D3F9D8 !important;
        color: #1B9AAA !important;
        border: none !important;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#assessmentsTable').DataTable({
        responsive: true,
        order: [[1, 'desc']],
        pageLength: 25,
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'copy',
                className: 'bg-[#40C9A2] text-white px-4 py-2 rounded-lg'
            },
            {
                extend: 'excel',
                className: 'bg-[#40C9A2] text-white px-4 py-2 rounded-lg',
                title: 'BIORADAR Assessments'
            },
            {
                extend: 'pdf',
                className: 'bg-[#40C9A2] text-white px-4 py-2 rounded-lg',
                title: 'BIORADAR Assessments'
            },
            {
                extend: 'print',
                className: 'bg-[#40C9A2] text-white px-4 py-2 rounded-lg'
            }
        ],
        language: {
            search: "Search assessments:",
            lengthMenu: "Show _MENU_ assessments per page",
            info: "Showing _START_ to _END_ of _TOTAL_ assessments",
            infoEmpty: "No assessments to show",
            infoFiltered: "(filtered from _MAX_ total assessments)",
            zeroRecords: "No matching assessments found"
        },
        initComplete: function() {
            // Add column filters for Type, Status, and Risk Level
            this.api().columns([2, 3, 4]).every(function() {
                var column = this;
                var title = $(column.header()).text();
                var select = $('<select class="border border-[#D3F9D8] rounded-lg px-2 py-1 text-sm ml-2"><option value="">All ' + title + '</option></select>')
                    .appendTo($(column.header()))
                    .on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                    });
                
                column.data().unique().sort().each(function(d, j) {
                    var text = $(d).text().trim();
                    if (text && text !== '-' && text !== 'Pending') {
                        select.append('<option value="' + text + '">' + text + '</option>');
                    }
                });
            });
        }
    });
});
</script>
@endpush
@endsection
