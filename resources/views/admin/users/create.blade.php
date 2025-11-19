@extends('layouts.app')

@section('title', 'Create New User')

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
<div class="max-w-3xl mx-auto animate__animated animate__fadeIn">
    <div class="mb-6">
        <a href="{{ route('admin.users') }}" class="text-[#1B9AAA] hover:text-[#40C9A2] flex items-center font-semibold transition duration-200">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Users
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-8 border border-[#D3F9D8]">
        <h1 class="text-3xl font-bold text-[#1B9AAA] mb-6">Create New User</h1>

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-xl">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                    <input type="password" name="password" id="password" required
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200">
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password *</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200">
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                    <select name="role" id="role" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200">
                        <option value="">Select Role</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="doctor" {{ old('role') === 'doctor' ? 'selected' : '' }}>Doctor</option>
                        <option value="patient" {{ old('role') === 'patient' ? 'selected' : '' }}>Patient</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="is_active" id="is_active"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200">
                        <option value="1" {{ old('is_active', '1') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 flex gap-4">
                <button type="submit" 
                        class="flex-1 bg-[#40C9A2] text-white px-6 py-3 rounded-xl font-semibold hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                    Create User
                </button>
                <a href="{{ route('admin.users') }}" 
                   class="flex-1 text-center bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-300 transition duration-300">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
