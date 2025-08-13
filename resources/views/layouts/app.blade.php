<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <link rel="icon" href="{{ asset('images/icons/logo.svg') }}" type="image/svg+xml">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="{{ asset('js/side-menu.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-navgreen flex">
            @include('partials.sidenav') <!-- Sidebar -->

            <!-- Main Content - Fixed to screen height -->
            <div class="flex-1 flex flex-col h-screen overflow-auto rounded-xl py-6 pr-6"
                :class="{ 'p-6': open, 'p-0': !open }">
                <!-- Scrollable Page Content -->
                <main class="flex-1 overflow-y-auto rounded-xl scrollbar-hidden bg-mainback">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @stack('modals')
        @livewireScripts
        @stack('scripts')
    </body>
</html>
