<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - ' . config('app.name', 'Indrasari Car Rental') : config('app.name', 'Indrasari Car Rental') }}</title>

    <!-- Zero-FOUC Theme Script (Instant Dark/Light detection) -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-[#F8FAFC] text-slate-900 antialiased dark:bg-[#0B0F19] dark:text-[#F8FAFC]">
    <!-- Top Navigation -->
    <x-navbar />

    <!-- Main Content Area -->
    <main class="flex-1 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-flash-messages />
            {{ $slot ?? '' }}
            @yield('content')
        </div>
    </main>

    <!-- Global Footer -->
    <x-footer />

    @stack('scripts')
</body>
</html>
