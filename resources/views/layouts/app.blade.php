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

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://kit.fontawesome.com/44a33d1db5.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #475569;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .dark ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        /* Smooth transitions for dark mode */
        * {
            transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease;
        }

        /* Hide scrollbar for panels */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="font-sans antialiased bg-white dark:bg-gray-900">

    @yield('content')

    <!-- Mobile Bottom Navigation -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 z-50">
        <div class="flex items-center justify-around h-16 px-2">
            <!-- Home -->
            <a href="/"
               class="flex flex-col items-center justify-center flex-1 h-full {{ request()->is('/') || request()->is('/home') ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400' }}">
                <i class="fa-{{ request()->is('/') || request()->is('/home') ? 'solid' : 'regular' }} fa-house text-2xl"></i>
            </a>

            <!-- Search -->
            <button id="mobile-search-toggle"
                    class="flex flex-col items-center justify-center flex-1 h-full text-gray-500 dark:text-gray-400">
                <i class="fa-regular fa-magnifying-glass text-2xl"></i>
            </button>

            <!-- Create (Center) -->
            <a href="{{ route('posts.create') }}"
               class="flex flex-col items-center justify-center flex-1 h-full text-gray-500 dark:text-gray-400">
                <i class="fa-regular fa-square-plus text-2xl"></i>
            </a>

            <!-- Notifications -->
            <button id="mobile-notification-toggle"
                    class="flex flex-col items-center justify-center flex-1 h-full text-gray-500 dark:text-gray-400 relative">
                <i class="fa-regular fa-heart text-2xl"></i>
                <span class="absolute top-2 right-1/4 w-1.5 h-1.5 bg-red-500 rounded-full"></span>
            </button>

            <!-- Profile -->
            @auth
            <a href="/profile"
               class="flex flex-col items-center justify-center flex-1 h-full">
                <img src="{{ auth()->user()->avatar
                        ? asset('storage/' . auth()->user()->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=06b6d4&color=fff'
                    }}"
                     alt="Profile"
                     class="w-7 h-7 rounded-full border-2 {{ request()->is('profile') ? 'border-gray-900 dark:border-white' : 'border-transparent' }}">
            </a>
            @else
            <a href="{{ route('login') }}"
               class="flex flex-col items-center justify-center flex-1 h-full text-gray-500 dark:text-gray-400">
                <i class="fa-regular fa-circle-user text-2xl"></i>
            </a>
            @endauth
        </div>
    </nav>

    <!-- Mobile Search Panel -->
    <div id="mobile-search-panel" class="lg:hidden hidden fixed inset-0 bg-white dark:bg-gray-900 z-50">
        <div class="flex flex-col h-full">
            <div class="flex items-center p-4 border-b border-gray-200 dark:border-gray-800">
                <button id="mobile-search-close" class="mr-3 text-gray-900 dark:text-white">
                    <i class="fa-solid fa-arrow-left text-xl"></i>
                </button>
                <div class="flex-1 relative">
                    <input type="text"
                           placeholder="Cari..."
                           class="w-full px-4 py-2 pl-10 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg border-0 focus:ring-2 focus:ring-cyan-500">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto p-4">
                <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                    <p class="text-sm">Cari kampanye atau pengguna</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Notification Panel -->
    <div id="mobile-notification-panel" class="lg:hidden hidden fixed inset-0 bg-white dark:bg-gray-900 z-50">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-800">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Notifikasi</h2>
                <button id="mobile-notification-close" class="text-gray-900 dark:text-white">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto">
                <div class="text-center text-gray-500 dark:text-gray-400 py-8 px-6">
                    <p class="text-sm">Belum ada notifikasi</p>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')

    <script>
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();

        // Mobile Search Panel
        document.addEventListener('DOMContentLoaded', function() {
            const mobileSearchToggle = document.getElementById('mobile-search-toggle');
            const mobileSearchPanel = document.getElementById('mobile-search-panel');
            const mobileSearchClose = document.getElementById('mobile-search-close');

            mobileSearchToggle?.addEventListener('click', () => {
                mobileSearchPanel?.classList.remove('hidden');
            });

            mobileSearchClose?.addEventListener('click', () => {
                mobileSearchPanel?.classList.add('hidden');
            });

            // Mobile Notification Panel
            const mobileNotificationToggle = document.getElementById('mobile-notification-toggle');
            const mobileNotificationPanel = document.getElementById('mobile-notification-panel');
            const mobileNotificationClose = document.getElementById('mobile-notification-close');

            mobileNotificationToggle?.addEventListener('click', () => {
                mobileNotificationPanel?.classList.remove('hidden');
            });

            mobileNotificationClose?.addEventListener('click', () => {
                mobileNotificationPanel?.classList.add('hidden');
            });
        });
    </script>

</body>

</html>
