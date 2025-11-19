<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIORADAR - Early Cancer Detection and Notification System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: #40C9A2;
            position: relative;
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #40C9A2 0%, #1B9AAA 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-25px) rotate(3deg);
            }
        }
        
        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }
        
        @keyframes gradientShift {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 1s ease-out forwards;
            opacity: 0;
        }
        
        .float {
            animation: float 6s ease-in-out infinite;
        }
        
        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            background-size: 1000px 100%;
            animation: shimmer 3s infinite;
        }
        
        .premium-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fcfb 100%);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }
        
        .premium-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(64, 201, 162, 0.1), transparent);
            transition: left 0.7s;
        }
        
        .premium-card:hover::before {
            left: 100%;
        }
        
        .premium-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 30px 60px rgba(27, 154, 170, 0.25);
        }
        
        .glass-morphism {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .btn-premium {
            background: linear-gradient(135deg, #40C9A2 0%, #1B9AAA 100%);
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
        }
        
        .btn-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        
        .btn-premium:hover::before {
            left: 100%;
        }
        
        .btn-premium:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(64, 201, 162, 0.5);
        }
        
        .stat-number {
            font-size: 3.5rem;
            font-weight: 900;
            letter-spacing: -0.05em;
        }
        
        .section-title {
            position: relative;
            display: inline-block;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #40C9A2, #1B9AAA);
            border-radius: 2px;
        }
        
        .feature-icon {
            background: linear-gradient(135deg, #40C9A2 0%, #1B9AAA 100%);
            box-shadow: 0 10px 30px rgba(64, 201, 162, 0.3);
        }
        
        .animated-gradient {
            background: #40C9A2;
            position: relative;
        }
        
        .mesh-gradient {
            background: #40C9A2;
        }
        
        .drop-shadow-lg {
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3), 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Modal animations */
        .modal-backdrop {
            animation: fadeIn 0.3s ease-out;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .modal-content {
            animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Blur background when modal is open */
        body.modal-open > *:not(.fixed) {
            filter: blur(4px);
            transition: filter 0.3s ease;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 antialiased">
    <!-- Navigation -->
    <nav class="glass-morphism sticky top-0 z-50 backdrop-blur-xl bg-white/80 border-b border-gray-200/50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center fade-in-up">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('bioradar-logo.png') }}" alt="BIORADAR Logo" class="w-16 h-16 rounded-2xl shadow-lg">
                        <div>
                            <h1 class="text-2xl font-black gradient-text tracking-tight">BIORADAR</h1>
                            <p class="text-xs text-gray-500 font-medium">Early Cancer Detection and Notification System</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4 fade-in-up">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-[#40C9A2] px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-gradient-to-r hover:from-[#D3F9D8] hover:to-[#B2F2BB]">
                            Dashboard
                        </a>
                    @else
                        <button onclick="openLoginModal()" class="text-gray-700 hover:text-[#40C9A2] px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-gray-100">
                            Login
                        </button>
                        <button onclick="openRegisterModal()" class="btn-premium text-white px-8 py-3 rounded-xl text-sm font-bold shadow-2xl">
                            Get Started Free
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg py-32 relative overflow-hidden mesh-gradient">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-20 left-20 w-96 h-96 bg-[#B2F2BB] rounded-full mix-blend-screen filter blur-3xl animate-pulse"></div>
            <div class="absolute top-60 right-20 w-[500px] h-[500px] bg-[#D3F9D8] rounded-full mix-blend-screen filter blur-3xl animate-pulse" style="animation-delay: 2s"></div>
            <div class="absolute bottom-20 left-1/3 w-96 h-96 bg-[#40C9A2] rounded-full mix-blend-screen filter blur-3xl animate-pulse" style="animation-delay: 4s"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Side - Content -->
                <div class="fade-in-up text-left">
                    <!-- Badge -->
                    <div class="mb-6">
                        <span class="glass-morphism px-6 py-3 rounded-full text-sm font-bold inline-flex items-center space-x-2 shadow-2xl text-white">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                            </span>
                            <span>AI-Powered Health Analysis</span>
                        </span>
                    </div>
                    
                    <!-- Main Heading -->
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-black mb-6 leading-tight" style="animation-delay: 0.1s">
                        <span class="block text-white drop-shadow-lg">Transform Your</span>
                        <span class="block text-white drop-shadow-lg">Health Journey with</span>
                        <span class="block text-white drop-shadow-lg">BIORADAR</span>
                    </h1>
                    
                    <!-- Subheading -->
                    <h2 class="text-xl md:text-2xl font-semibold mb-6 text-white fade-in-up drop-shadow-lg" style="animation-delay: 0.2s">
                        Early Cancer Detection & Real-Time Risk Assessment Powered by Advanced AI
                    </h2>
                    
                    <!-- Description -->
                    <p class="text-base md:text-lg mb-8 text-white font-medium fade-in-up drop-shadow-lg" style="animation-delay: 0.3s">
                        Get instant health insights with our intelligent symptom analysis system and connect with medical professionals for comprehensive care.
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 fade-in-up" style="animation-delay: 0.4s">
                        @guest
                            <button onclick="openRegisterModal()" class="bg-white text-[#1B9AAA] px-8 py-4 rounded-2xl text-base font-bold hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 shadow-2xl inline-flex items-center justify-center group">
                                Start Free Assessment
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </button>
                            <a href="#features" class="glass-morphism text-white px-8 py-4 rounded-2xl text-base font-bold hover:bg-white/20 transition-all duration-300 transform hover:scale-105 inline-flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Watch Demo
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="bg-white text-[#1B9AAA] px-8 py-4 rounded-2xl text-base font-bold hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 shadow-2xl">Go to Dashboard</a>
                        @endguest
                    </div>
                </div>
                
                <!-- Right Side - Logo -->
                <div class="fade-in-up flex justify-center md:justify-end" style="animation-delay: 0.2s">
                    <div class="relative">
                        <div class="w-80 h-80 md:w-96 md:h-96 lg:w-[450px] lg:h-[450px] rounded-full overflow-hidden shadow-2xl float bg-white/10 backdrop-blur-sm border-4 border-white/30">
                            <img src="{{ asset('bioradar-logo.png') }}" alt="BIORADAR Logo" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 w-64 h-16 bg-black/30 rounded-full blur-3xl"></div>
                    </div>
                </div>
            </div>
                
                <!-- Stats -->
                <div class="grid grid-cols-3 gap-8 max-w-4xl mx-auto mt-20 fade-in-up" style="animation-delay: 0.6s">
                    <div class="glass-morphism p-6 rounded-2xl">
                        <div class="stat-number text-white drop-shadow-lg">99%</div>
                        <p class="text-white text-base font-bold mt-2 drop-shadow">Accuracy Rate</p>
                    </div>
                    <div class="glass-morphism p-6 rounded-2xl">
                        <div class="stat-number text-white drop-shadow-lg">24/7</div>
                        <p class="text-white text-base font-bold mt-2 drop-shadow">AI Support</p>
                    </div>
                    <div class="glass-morphism p-6 rounded-2xl">
                        <div class="stat-number text-white drop-shadow-lg">10k+</div>
                        <p class="text-white text-base font-bold mt-2 drop-shadow">Users Helped</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <div class="inline-block px-6 py-2 bg-[#1B9AAA] rounded-full text-white font-bold text-sm mb-6 shadow-lg">
                    HOW IT WORKS
                </div>
                <h2 class="text-5xl md:text-6xl font-black text-gray-900 mb-6 section-title">
                    Simple. Smart. Secure.
                </h2>
                <p class="text-xl text-gray-700 max-w-3xl mx-auto leading-relaxed font-medium">
                    Our AI-powered platform makes early cancer detection accessible and accurate with just three simple steps
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-10">
                <!-- Feature 1 -->
                <div class="premium-card p-10 rounded-3xl shadow-2xl border border-gray-100">
                    <div class="relative mb-8">
                        <div class="feature-icon w-24 h-24 rounded-3xl flex items-center justify-center float">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2 bg-[#40C9A2] text-white rounded-full w-10 h-10 flex items-center justify-center font-black text-lg">
                            1
                        </div>
                    </div>
                    <h3 class="text-2xl font-black mb-4 text-gray-900">Submit Symptoms</h3>
                    <p class="text-gray-700 leading-relaxed text-lg font-medium">Enter your symptoms, demographic data, and physical information through our intuitive interface designed for ease of use.</p>
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center text-sm text-[#40C9A2] font-semibold">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            2 minutes to complete
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="premium-card p-10 rounded-3xl shadow-2xl border border-gray-100" style="animation-delay: 0.2s">
                    <div class="relative mb-8">
                        <div class="feature-icon w-24 h-24 rounded-3xl flex items-center justify-center float" style="animation-delay: 1s">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2 bg-[#40C9A2] text-white rounded-full w-10 h-10 flex items-center justify-center font-black text-lg">
                            2
                        </div>
                    </div>
                    <h3 class="text-2xl font-black mb-4 text-gray-900">AI Analysis</h3>
                    <p class="text-gray-700 leading-relaxed text-lg font-medium">Receive instant automated risk assessment powered by machine learning or request professional doctor evaluation.</p>
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center text-sm text-[#40C9A2] font-semibold">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Real-time processing
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="premium-card p-10 rounded-3xl shadow-2xl border border-gray-100" style="animation-delay: 0.4s">
                    <div class="relative mb-8">
                        <div class="feature-icon w-24 h-24 rounded-3xl flex items-center justify-center float" style="animation-delay: 2s">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2 bg-[#40C9A2] text-white rounded-full w-10 h-10 flex items-center justify-center font-black text-lg">
                            3
                        </div>
                    </div>
                    <h3 class="text-2xl font-black mb-4 text-gray-900">Get Results</h3>
                    <p class="text-gray-700 leading-relaxed text-lg font-medium">Receive comprehensive risk evaluation with personalized recommendations delivered instantly to your secure portal.</p>
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center text-sm text-[#40C9A2] font-semibold">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Actionable insights
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- User Types Section -->
    <section class="bg-gradient-to-br from-gray-50 to-[#D3F9D8]/20 py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <div class="inline-block px-6 py-2 bg-[#1B9AAA] rounded-full text-white font-bold text-sm mb-6 shadow-lg">
                    DESIGNED FOR EVERYONE
                </div>
                <h2 class="text-5xl md:text-6xl font-black text-gray-900 mb-6 section-title">
                    Who Benefits from BIORADAR?
                </h2>
                <p class="text-xl text-gray-700 max-w-3xl mx-auto leading-relaxed font-medium">
                    A comprehensive platform serving patients, healthcare professionals, and administrators
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-10">
                <!-- Patients -->
                <div class="premium-card p-10 rounded-3xl shadow-2xl border-t-4 border-[#40C9A2] hover:border-t-8">
                    <div class="text-center">
                        <div class="feature-icon w-28 h-28 rounded-3xl flex items-center justify-center mx-auto mb-8 float">
                            <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black mb-6 text-gray-900">For Patients</h3>
                        <p class="text-gray-700 mb-8 leading-relaxed font-medium text-lg">Take control of your health journey with instant AI-powered insights</p>
                        <ul class="text-left text-gray-800 space-y-4">
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-[#40C9A2] mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Submit symptoms and health data securely</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-[#40C9A2] mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Get instant automated risk assessments</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-[#40C9A2] mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Request professional doctor evaluations</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-[#40C9A2] mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Track your complete assessment history</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Doctors -->
                <div class="premium-card p-10 rounded-3xl shadow-2xl border-t-4 border-[#40C9A2] hover:border-t-8" style="animation-delay: 0.2s">
                    <div class="text-center">
                        <div class="feature-icon w-28 h-28 rounded-3xl flex items-center justify-center mx-auto mb-8 float" style="animation-delay: 1s">
                            <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black mb-6 text-gray-900">For Doctors</h3>
                        <p class="text-gray-700 mb-8 leading-relaxed font-medium text-lg">Streamline patient assessments with AI-assisted diagnostics</p>
                        <ul class="text-left text-gray-800 space-y-4">
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-[#40C9A2] mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Review patient submissions efficiently</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-[#40C9A2] mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Provide accurate risk evaluations</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-[#40C9A2] mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Send recommendations via email instantly</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-[#40C9A2] mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Access comprehensive patient histories</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Admin -->
                <div class="premium-card p-10 rounded-3xl shadow-2xl border-t-4 border-[#40C9A2] hover:border-t-8" style="animation-delay: 0.4s">
                    <div class="text-center">
                        <div class="feature-icon w-28 h-28 rounded-3xl flex items-center justify-center mx-auto mb-8 float" style="animation-delay: 2s">
                            <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black mb-6 text-gray-900">For Admins</h3>
                        <p class="text-gray-700 mb-8 leading-relaxed font-medium text-lg">Complete system oversight and management capabilities</p>
                        <ul class="text-left text-gray-800 space-y-4">
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-[#40C9A2] mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Manage all user accounts and roles</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-[#40C9A2] mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Access comprehensive system analytics</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-[#40C9A2] mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Monitor all assessments and activities</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-[#40C9A2] mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-medium">Full platform control and oversight</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="animated-gradient text-white py-32 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-20 w-[600px] h-[600px] bg-white rounded-full mix-blend-screen filter blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 right-20 w-[600px] h-[600px] bg-white rounded-full mix-blend-screen filter blur-3xl animate-pulse" style="animation-delay: 3s"></div>
        </div>
        <div class="max-w-5xl mx-auto text-center px-4 relative z-10">
            <div class="glass-morphism inline-block px-6 py-2 rounded-full text-sm font-bold mb-8">
                JOIN 10,000+ USERS
            </div>
            <h2 class="text-6xl md:text-7xl font-black mb-6 leading-tight text-white">
                Ready to Transform Your<br/>Health Journey?
            </h2>
            <p class="text-2xl mb-12 text-white max-w-3xl mx-auto font-normal">
                Start your free assessment today and take the first step towards early detection and peace of mind
            </p>
            @guest
                <div class="flex flex-col sm:flex-row justify-center items-center gap-6">
                    <button onclick="openRegisterModal()" class="bg-white text-[#1B9AAA] px-12 py-5 rounded-2xl text-xl font-black hover:bg-gray-50 transition-all duration-300 transform hover:scale-110 inline-flex items-center shadow-2xl group">
                        Start Free Assessment
                        <svg class="w-7 h-7 ml-3 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </button>
                    <div class="flex items-center space-x-3 text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-semibold">No credit card required • 100% Free</span>
                    </div>
                </div>
            @endguest
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        <img src="{{ asset('bioradar-logo.png') }}" alt="BIORADAR Logo" class="w-16 h-16 rounded-2xl shadow-lg">
                        <div>
                            <h3 class="text-2xl font-black text-white">BIORADAR</h3>
                            <p class="text-xs text-gray-400 font-medium">Early Cancer Detection and Notification System</p>
                        </div>
                    </div>
                    <p class="text-gray-400 leading-relaxed mb-6 max-w-md">
                        Pioneering early cancer detection through AI-powered analysis and professional medical evaluation. Your health, our priority.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-[#40C9A2] transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-[#40C9A2] transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-[#40C9A2] transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-6">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-[#40C9A2] transition-colors">About Us</a></li>
                        <li><a href="#features" class="text-gray-400 hover:text-[#40C9A2] transition-colors">How It Works</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-[#40C9A2] transition-colors">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-[#40C9A2] transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-6">Legal</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-[#40C9A2] transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-[#40C9A2] transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-[#40C9A2] transition-colors">HIPAA Compliance</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-[#40C9A2] transition-colors">Medical Disclaimer</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm mb-4 md:mb-0">
                        © 2025 BIORADAR. All rights reserved.
                    </p>
                    <p class="text-gray-500 text-xs max-w-md text-center md:text-right">
                        This system is for informational purposes only and does not replace professional medical advice, diagnosis, or treatment.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // SweetAlert for demo interactions
        @guest
        setTimeout(() => {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('welcome') === 'true') {
                Swal.fire({
                    title: 'Welcome to BIORADAR!',
                    text: 'Your health is our priority. Get started with early cancer detection today.',
                    icon: 'success',
                    confirmButtonColor: '#40C9A2',
                    confirmButtonText: 'Get Started'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("register") }}';
                    }
                });
            }
        }, 1000);
        @endguest

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Modal functions
        function openLoginModal() {
            const modal = document.getElementById('loginModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            document.body.classList.add('modal-open');
            // Trigger reflow to ensure animation plays
            void modal.offsetWidth;
        }

        function closeLoginModal() {
            const modal = document.getElementById('loginModal');
            modal.classList.add('hidden');
            if (!document.getElementById('registerModal').classList.contains('hidden')) return;
            document.body.style.overflow = 'auto';
            document.body.classList.remove('modal-open');
        }

        function openRegisterModal() {
            const modal = document.getElementById('registerModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            document.body.classList.add('modal-open');
            // Trigger reflow to ensure animation plays
            void modal.offsetWidth;
        }

        function closeRegisterModal() {
            const modal = document.getElementById('registerModal');
            modal.classList.add('hidden');
            if (!document.getElementById('loginModal').classList.contains('hidden')) return;
            document.body.style.overflow = 'auto';
            document.body.classList.remove('modal-open');
        }

        // Close modal on outside click
        window.onclick = function(event) {
            const loginModal = document.getElementById('loginModal');
            const registerModal = document.getElementById('registerModal');
            if (event.target == loginModal) {
                closeLoginModal();
            }
            if (event.target == registerModal) {
                closeRegisterModal();
            }
        }
    </script>

    <!-- Login Modal -->
    <div id="loginModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 modal-backdrop">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 border border-[#D3F9D8] relative max-h-[90vh] overflow-y-auto modal-content">
            <button onclick="closeLoginModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('bioradar-logo.png') }}" alt="BIORADAR Logo" class="w-20 h-20 rounded-2xl shadow-xl">
                </div>
                <h2 class="text-2xl font-black text-[#1B9AAA]">BIORADAR</h2>
                <p class="mt-1 text-xs text-gray-500 font-medium">Early Cancer Detection and Notification System</p>
                <p class="mt-3 text-sm text-gray-700 font-semibold">Sign in to your account</p>
            </div>

            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
                        <input id="email" name="email" type="email" required 
                               class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200 sm:text-sm" 
                               placeholder="you@example.com">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input id="password" name="password" type="password" required 
                               class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200 sm:text-sm" 
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" 
                               class="h-4 w-4 text-[#40C9A2] focus:ring-[#40C9A2] border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                    </div>
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-[#40C9A2] hover:bg-[#1B9AAA] transition duration-300">
                        Sign in
                    </button>
                </div>
            </form>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Don't have an account? 
                    <button onclick="closeLoginModal(); openRegisterModal();" class="font-semibold text-[#1B9AAA] hover:text-[#40C9A2] transition duration-200">
                        Register here
                    </button>
                </p>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div id="registerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 modal-backdrop">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 border border-[#D3F9D8] relative max-h-[90vh] overflow-y-auto modal-content">
            <button onclick="closeRegisterModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('bioradar-logo.png') }}" alt="BIORADAR Logo" class="w-20 h-20 rounded-2xl shadow-xl">
                </div>
                <h2 class="text-2xl font-black text-[#1B9AAA]">BIORADAR</h2>
                <p class="mt-1 text-xs text-gray-500 font-medium">Early Cancer Detection and Notification System</p>
                <p class="mt-3 text-sm text-gray-700 font-semibold">Create your account</p>
            </div>

            <form class="space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input id="name" name="name" type="text" required 
                               class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200 sm:text-sm" 
                               placeholder="John Doe">
                    </div>
                    <div>
                        <label for="register-email" class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
                        <input id="register-email" name="email" type="email" required 
                               class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200 sm:text-sm" 
                               placeholder="you@example.com">
                    </div>
                    <div>
                        <label for="register-password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input id="register-password" name="password" type="password" required 
                               class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200 sm:text-sm" 
                               placeholder="••••••••">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required 
                               class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200 sm:text-sm" 
                               placeholder="••••••••">
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">I am a</label>
                        <select id="role" name="role" required
                                class="block w-full px-4 py-3 border border-gray-300 bg-white rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#40C9A2] focus:border-[#40C9A2] transition duration-200 sm:text-sm">
                            <option value="">Select your role</option>
                            <option value="patient">Patient</option>
                            <option value="doctor">Doctor</option>
                        </select>
                    </div>
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-[#40C9A2] hover:bg-[#1B9AAA] transition duration-300">
                        Create Account
                    </button>
                </div>
            </form>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Already have an account? 
                    <button onclick="closeRegisterModal(); openLoginModal();" class="font-semibold text-[#1B9AAA] hover:text-[#40C9A2] transition duration-200">
                        Login here
                    </button>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
