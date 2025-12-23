<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') - {{ config('app.name', 'OpenHands') }}
        @else
            {{ config('app.name', 'OpenHands') }} - Platform Donasi Sosial
        @endif
    </title>

    {{-- font --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- font awesome --}}
    <script src="https://kit.fontawesome.com/44a33d1db5.js" crossorigin="anonymous"></script>

    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>


   {{-- style --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased bg-white dark:bg-gray-900">

    {{-- topbar --}}
    @include('partials.mobile-topbar')

    <div class="min-h-screen bg-white dark:bg-gray-900">
        <div class="flex">
            {{-- sidebar --}}
            @include('partials.sidebar-left')

            {{-- main --}}
            <main class="flex-1 lg:ml-64 pb-16 lg:pb-0 mt-20 lg:mt-0">
                @yield('content')
            </main>

        </div>
    </div>

    {{-- bottom nav --}}
    @include('partials.bottom-nav')

    @stack('scripts')

    <script>
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

</body>

</html>
