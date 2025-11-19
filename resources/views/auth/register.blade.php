<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - BIORADAR</title>
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body class="bg-gradient-to-br from-[#D3F9D8] via-white to-[#B2F2BB] min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-2xl shadow-2xl p-8 border border-[#D3F9D8]">
                <div class="text-center mb-8">
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('bioradar-logo.png') }}" alt="BIORADAR Logo" class="w-24 h-24 rounded-2xl shadow-xl">
                    </div>
                    <h2 class="text-3xl font-black text-[#1B9AAA]">
                        BIORADAR
                    </h2>
                    <p class="mt-1 text-xs text-gray-500 font-medium">
                        Early Cancer Detection and Notification System
                    </p>
                    <p class="mt-3 text-sm text-gray-700 font-semibold">
                        Create your account
                    </p>
                </div>
            <form class="space-y-5" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input id="name" name="name" type="text" required 
                               class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200 sm:text-sm" 
                               placeholder="John Doe" value="{{ old('name') }}">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                        <input id="email" name="email" type="email" required 
                               class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200 sm:text-sm" 
                               placeholder="john@example.com" value="{{ old('email') }}">
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input id="password" name="password" type="password" required 
                               class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200 sm:text-sm" 
                               placeholder="••••••••">
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required 
                               class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200 sm:text-sm" 
                               placeholder="••••••••">
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Register as</label>
                        <select id="role" name="role" required 
                                class="block w-full px-4 py-3 border border-gray-300 bg-white rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200 sm:text-sm">
                            <option value="patient" {{ old('role') === 'patient' ? 'selected' : '' }}>Patient</option>
                            <option value="doctor" {{ old('role') === 'doctor' ? 'selected' : '' }}>Doctor</option>
                        </select>
                    </div>
                </div>

                @if($errors->any())
                    <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-xl">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-[#40C9A2] to-[#1B9AAA] hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                        Create Account
                    </button>
                </div>
            </form>

                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="font-semibold text-[#1B9AAA] hover:text-[#40C9A2] transition duration-200">
                            Sign in
                        </a>
                    </p>
                    <a href="{{ route('landing') }}" class="mt-3 inline-block text-sm text-[#1B9AAA] hover:text-[#40C9A2] font-medium transition duration-200">
                        ← Back to home
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
