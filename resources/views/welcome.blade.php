<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MyGradesTrack - Welcome</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
   <body class="bg-[#F7f7f7] text-[#1b1b18] min-h-screen flex flex-col">
      <!-- TOP SECTION: Full width, 65% of screen height -->
        <div class="h-[65vh] w-full bg-[#129990]">
            <header class="w-full max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 text-sm mb-6">
                @if (Route::has('login'))
                    <nav class="flex items-center justify-between py-4">
                        <!-- Brand -->
                        <div class="text-lg font-semibold text-white">
                            MYGRADETRACK
                        </div>

                        <!-- Auth Links -->
                        <div class="flex items-center gap-4">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] bg-white rounded-sm text-sm leading-normal">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                class="inline-block px-5 py-1.5 text-[#1b1b18] bg-white border border-transparent hover:border-[#19140035] rounded-sm text-sm leading-normal">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                    class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] bg-white rounded-sm text-sm leading-normal">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </nav>
                @endif
            </header>

            <!-- Main Content (Image + Text) -->
            <div class="flex items-center justify-center h-[calc(65vh-5rem)] max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">
                <!-- Image (Left) -->
                <div class="w-1/2 h-full flex items-center justify-center">
                    <img src="{{ asset('images/illustration/home_image.png') }}" alt="Illustration" class="h-full object-contain">
                </div>

                <!-- Text (Right) -->
                <div class="w-1/2 text-white px-6">
                    <h1 class="text-3xl font-bold mb-4">Welcome!</h1>
                    <p class="mb-6 text-lg">Track your grades and GPA effortlessly. <b>MYGRADETRACK</b> keeps your academic performance organized and easy to access.</p>
                    <a href="{{ route('register') }}" class="inline-block bg-white text-[#129990] px-6 py-2 rounded-md font-semibold hover:bg-gray-100 transition">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
        <!-- Features Section -->
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="border-[1.5px] border-[#566A7F] rounded-[15px] p-6 bg-white shadow-sm">
                    <h2 class="text-lg sm:text-xl md:text-2xl font-semibold text-[#129990] mb-2">Automatic Computation</h2>
                    <p class="text-[#1b1b18]">Instantly calculates your current weighted average based on subject units.</p>
                </div>

                <!-- Feature 2 -->
                <div class="border-[1.5px] border-[#566A7F] rounded-[15px] p-6 bg-white shadow-sm">
                    <h2 class="text-xl font-semibold text-[#129990] mb-2">Data Visualization</h2>
                    <p class="text-[#1b1b18]">Visual charts and graphs to easily track academic performance over time.</p>
                </div>

                <!-- Feature 3 -->
                <div class="border-[1.5px] border-[#566A7F] rounded-[15px] p-6 bg-white shadow-sm">
                    <h2 class="text-xl font-semibold text-[#129990] mb-2">Smart Semester Management</h2>
                    <p class="text-[#1b1b18]">Organize and manage your grades efficiently by semester with ease.</p>
                </div>
            </div>
        </div>

        <!-- Optional spacer -->
        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif

    </body>

</html>
