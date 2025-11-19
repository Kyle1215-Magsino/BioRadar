<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BIORADAR</title>
    
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
                        Sign in to your account
                    </p>
                </div>
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
                        <input id="email" name="email" type="email" required 
                               class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200 sm:text-sm" 
                               placeholder="you@example.com" value="{{ old('email') }}">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input id="password" name="password" type="password" required 
                               class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200 sm:text-sm" 
                               placeholder="••••••••">
                    </div>
                </div>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" 
                               class="h-4 w-4 text-[#40C9A2] focus:ring-[#40C9A2] border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Remember me
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-[#40C9A2] to-[#1B9AAA] hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                        Sign in
                    </button>
                </div>
            </form>

                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="font-semibold text-[#1B9AAA] hover:text-[#40C9A2] transition duration-200">
                            Register here
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
