<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BIORADAR')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // Configure jQuery AJAX to include Laravel CSRF token when using CDN jQuery
        (function () {
            var token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (window.jQuery && token) {
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
            }
        })();
    </script>
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    
    <style>
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .slide-in {
            animation: slideIn 0.5s ease-out;
        }
        
        .hover-scale {
            transition: transform 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.05);
        }
        
        .nav-item {
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 0;
            background: linear-gradient(to bottom, #40C9A2, #1B9AAA);
            border-radius: 0 4px 4px 0;
            transition: height 0.3s ease;
        }
        
        .nav-item:hover::before,
        .nav-item.active::before {
            height: 70%;
        }
        
        .stat-card {
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(64, 201, 162, 0.2);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-[#40C9A2] to-[#1B9AAA] shadow-lg sticky top-0 z-50 border-b-2 border-[#40C9A2]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center slide-in">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('bioradar-logo.png') }}" alt="BIORADAR Logo" class="w-12 h-12 rounded-xl shadow-lg">
                        <div>
                            <h1 class="text-xl font-bold text-white">BIORADAR</h1>
                            <p class="text-[10px] text-white/90 font-medium">Early Cancer Detection and Notification System</p>
                        </div>
                    </div>
                    <span class="ml-4 px-3 py-1 bg-white/20 text-white text-xs font-bold rounded-full">
                        @auth
                            {{ ucfirst(auth()->user()->role) }} Portal
                        @endauth
                    </span>
                </div>
                <div class="flex items-center space-x-4 slide-in">
                    @auth
                        <div class="flex items-center space-x-2 px-3 py-2 bg-white/20 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-white font-medium">{{ auth()->user()->name }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-white hover:text-white px-4 py-2 rounded-lg text-sm font-bold transition-all duration-300 hover:bg-white/20">
                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        @auth
        <aside class="w-64 bg-white shadow-xl min-h-screen border-r-2 border-gray-200">
            <nav class="mt-5 px-3 space-y-2">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} group flex items-center px-4 py-3 text-base leading-6 font-medium rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-[#40C9A2] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100 hover:text-[#1B9AAA]' }}">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }} group flex items-center px-4 py-3 text-base leading-6 font-medium rounded-xl {{ request()->routeIs('admin.users*') ? 'bg-[#40C9A2] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100 hover:text-[#1B9AAA]' }}">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Users
                    </a>
                    <a href="{{ route('admin.assessments') }}" class="nav-item {{ request()->routeIs('admin.assessments*') ? 'active' : '' }} group flex items-center px-4 py-3 text-base leading-6 font-medium rounded-xl {{ request()->routeIs('admin.assessments*') ? 'bg-[#40C9A2] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100 hover:text-[#1B9AAA]' }}">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Assessments
                    </a>
                @elseif(auth()->user()->isDoctor())
                    <a href="{{ route('doctor.dashboard') }}" class="nav-item {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }} group flex items-center px-4 py-3 text-base leading-6 font-medium rounded-xl {{ request()->routeIs('doctor.dashboard') ? 'bg-[#40C9A2] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100 hover:text-[#1B9AAA]' }}">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('doctor.assessments.pending') }}" class="nav-item {{ request()->routeIs('doctor.assessments.pending') ? 'active' : '' }} group flex items-center px-4 py-3 text-base leading-6 font-medium rounded-xl {{ request()->routeIs('doctor.assessments.pending') ? 'bg-[#40C9A2] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100 hover:text-[#1B9AAA]' }}">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Pending Assessments
                    </a>
                    <a href="{{ route('doctor.assessments') }}" class="nav-item {{ request()->routeIs('doctor.assessments') ? 'active' : '' }} group flex items-center px-4 py-3 text-base leading-6 font-medium rounded-xl {{ request()->routeIs('doctor.assessments') ? 'bg-[#40C9A2] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100 hover:text-[#1B9AAA]' }}">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        My Assessments
                    </a>
                @elseif(auth()->user()->isPatient())
                    <a href="{{ route('patient.dashboard') }}" class="nav-item {{ request()->routeIs('patient.dashboard') ? 'active' : '' }} group flex items-center px-4 py-3 text-base leading-6 font-medium rounded-xl {{ request()->routeIs('patient.dashboard') ? 'bg-[#40C9A2] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100 hover:text-[#1B9AAA]' }}">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('patient.profile') }}" class="nav-item {{ request()->routeIs('patient.profile') ? 'active' : '' }} group flex items-center px-4 py-3 text-base leading-6 font-medium rounded-xl {{ request()->routeIs('patient.profile') ? 'bg-[#40C9A2] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100 hover:text-[#1B9AAA]' }}">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        My Profile
                    </a>
                    <a href="{{ route('patient.assessment.create') }}" class="nav-item {{ request()->routeIs('patient.assessment.create') ? 'active' : '' }} group flex items-center px-4 py-3 text-base leading-6 font-medium rounded-xl {{ request()->routeIs('patient.assessment.create') ? 'bg-[#40C9A2] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100 hover:text-[#1B9AAA]' }}">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        New Assessment
                    </a>
                    <a href="{{ route('patient.assessments') }}" class="nav-item {{ request()->routeIs('patient.assessments') ? 'active' : '' }} group flex items-center px-4 py-3 text-base leading-6 font-medium rounded-xl {{ request()->routeIs('patient.assessments') ? 'bg-[#40C9A2] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100 hover:text-[#1B9AAA]' }}"
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        My Assessments
                    </a>
                @endif
            </nav>
        </aside>
        @endauth

        <!-- Main Content -->
        <main class="flex-1 p-8">
            @if(session('success'))
                <div class="mb-4 bg-[#D3F9D8] border border-[#40C9A2] text-[#1B9AAA] px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    @stack('scripts')
</body>
</html>
