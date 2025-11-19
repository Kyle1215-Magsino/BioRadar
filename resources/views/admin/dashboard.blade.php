@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto animate__animated animate__fadeIn">
    <h1 class="text-3xl font-bold text-[#1B9AAA] mb-8">Admin Dashboard</h1>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <div class="stat-card bg-white rounded-2xl shadow-lg p-6 transform hover:-translate-y-2 transition duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-[#40C9A2] rounded-xl p-3 shadow-md">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <h3 class="text-gray-500 text-xs font-medium">Total Users</h3>
                    <p class="text-2xl font-semibold text-[#1B9AAA]">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl shadow-lg p-6 transform hover:-translate-y-2 transition duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-[#40C9A2] rounded-xl p-3 shadow-md">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <h3 class="text-gray-500 text-xs font-medium">Patients</h3>
                    <p class="text-2xl font-semibold bg-[#40C9A2] bg-clip-text text-transparent">{{ $stats['total_patients'] }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl shadow-lg p-6 transform hover:-translate-y-2 transition duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-[#40C9A2] rounded-xl p-3 shadow-md">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <h3 class="text-gray-500 text-xs font-medium">Doctors</h3>
                    <p class="text-2xl font-semibold bg-gradient-to-r from-[#40C9A2] to-[#B2F2BB] bg-clip-text text-transparent">{{ $stats['total_doctors'] }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl shadow-lg p-6 transform hover:-translate-y-2 transition duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gradient-to-br from-[#1B9AAA] to-[#40C9A2] rounded-xl p-3 shadow-md">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <h3 class="text-gray-500 text-xs font-medium">Assessments</h3>
                    <p class="text-2xl font-semibold text-[#1B9AAA]">{{ $stats['total_assessments'] }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl shadow-lg p-6 transform hover:-translate-y-2 transition duration-300">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-[#D3F9D8] rounded-xl p-3 shadow-md">
                    <svg class="h-6 w-6 text-[#1B9AAA]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <h3 class="text-gray-500 text-xs font-medium">Pending</h3>
                    <p class="text-2xl font-semibold bg-[#B2F2BB] bg-clip-text text-transparent">{{ $stats['pending_assessments'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-[#D3F9D8]">
        <h2 class="text-xl font-semibold text-[#1B9AAA] mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.users.create') }}" class="flex items-center p-4 bg-[#B2F2BB] rounded-xl hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
                <svg class="h-8 w-8 text-[#1B9AAA]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                <div class="ml-4">
                    <h3 class="font-semibold text-[#1B9AAA]">Create User</h3>
                    <p class="text-sm text-gray-600">Add new users to the system</p>
                </div>
            </a>
            <a href="{{ route('admin.users') }}" class="flex items-center p-4 bg-[#40C9A2] rounded-xl hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <div class="ml-4">
                    <h3 class="font-semibold text-white">Manage Users</h3>
                    <p class="text-sm text-white opacity-90">View and manage all users</p>
                </div>
            </a>
            <a href="{{ route('admin.assessments') }}" class="flex items-center p-4 bg-gradient-to-r from-[#40C9A2] to-[#1B9AAA] rounded-xl hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <div class="ml-4">
                    <h3 class="font-semibold text-white">View Assessments</h3>
                    <p class="text-sm text-white opacity-90">Browse all assessments</p>
                </div>
            </a>
        </div>
    </div>

    <!-- System Information -->
    <div class="bg-gradient-to-r from-[#40C9A2] to-[#1B9AAA] rounded-2xl shadow-xl p-8 text-white transform hover:shadow-2xl transition duration-300">
        <h2 class="text-2xl font-bold mb-2">BIORADAR System</h2>
        <p class="text-[#D3F9D8] mb-4">Early Cancer Detection and Notification System</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white bg-opacity-20 rounded-xl p-4 backdrop-blur-sm hover:bg-opacity-30 transition duration-300">
                <h3 class="font-semibold mb-1">System Status</h3>
                <p class="text-sm">Operational</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-xl p-4 backdrop-blur-sm hover:bg-opacity-30 transition duration-300">
                <h3 class="font-semibold mb-1">Version</h3>
                <p class="text-sm">1.0.0</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-xl p-4 backdrop-blur-sm hover:bg-opacity-30 transition duration-300">
                <h3 class="font-semibold mb-1">Last Updated</h3>
                <p class="text-sm">{{ now()->format('M d, Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
