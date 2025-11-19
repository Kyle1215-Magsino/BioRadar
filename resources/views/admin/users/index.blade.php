@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="max-w-7xl mx-auto animate__animated animate__fadeIn">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-[#1B9AAA]">Manage Users</h1>
        <a href="{{ route('admin.users.create') }}" class="bg-[#40C9A2] text-white px-6 py-3 rounded-xl font-semibold hover:shadow-xl transform hover:-translate-y-1 transition duration-300 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create New User
        </a>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl shadow-xl border border-[#D3F9D8] overflow-hidden">
        <div class="overflow-x-auto p-4">
            <table id="usersTable" class="min-w-full divide-y divide-[#D3F9D8] display responsive nowrap" style="width:100%">
                <thead class="bg-[#B2F2BB]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#1B9AAA] uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#1B9AAA] uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#1B9AAA] uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#1B9AAA] uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#1B9AAA] uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-[#D3F9D8]">
                    @foreach($users as $user)
                    <tr class="hover:bg-[#D3F9D8] transition duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-[#40C9A2] rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($user->role === 'admin') bg-[#D3F9D8] text-[#1B9AAA]
                                @elseif($user->role === 'doctor') bg-[#B2F2BB] text-[#1B9AAA]
                                @else bg-[#B2F2BB] text-[#1B9AAA]
                                @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($user->is_active) bg-[#D3F9D8] text-[#1B9AAA]
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-[#1B9AAA] hover:text-[#40C9A2] font-semibold transition duration-200">Edit</a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-red-600 hover:text-red-900 font-semibold transition duration-200 delete-btn" data-user-name="{{ $user->name }}">Delete</button>
                            </form>
                            @endif
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
    // Show success message
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
    var table = $('#usersTable').DataTable({
        responsive: true,
        order: [[3, 'desc']],
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
                title: 'BIORADAR Users'
            },
            {
                extend: 'pdf',
                className: 'bg-[#40C9A2] text-white px-4 py-2 rounded-lg',
                title: 'BIORADAR Users'
            },
            {
                extend: 'print',
                className: 'bg-[#40C9A2] text-white px-4 py-2 rounded-lg'
            }
        ],
        language: {
            search: "Search users:",
            lengthMenu: "Show _MENU_ users per page",
            info: "Showing _START_ to _END_ of _TOTAL_ users",
            infoEmpty: "No users to show",
            infoFiltered: "(filtered from _MAX_ total users)",
            zeroRecords: "No matching users found"
        },
        initComplete: function() {
            // Add column filters
            this.api().columns([1, 2]).every(function() {
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
                    if (text) {
                        select.append('<option value="' + text + '">' + text + '</option>');
                    }
                });
            });
        }
    });

    // SweetAlert for delete confirmation
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var userName = $(this).data('user-name');
        
        Swal.fire({
            title: 'Delete User?',
            text: 'Are you sure you want to delete ' + userName + '? This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush
@endsection
