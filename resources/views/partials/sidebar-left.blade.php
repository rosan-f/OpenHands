<div class="flex flex-col h-full">
    <!-- Logo & Brand -->
    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800">
        <a href="/" class="flex items-center space-x-3 group">
            <div class="relative">
                <div class="w-10 h-10 bg-linear-to-br from-cyan-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" />
                    </svg>
                </div>
                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white dark:border-gray-900"></div>
            </div>
            <div class="flex-1">
                <h1 class="text-xl font-bold text-gray-900 dark:text-white tracking-tight">OpenHands</h1>
                <p class="text-xs text-gray-500 dark:text-gray-400">Platform Donasi</p>
            </div>
        </a>
    </div>

    <!-- User Profile Section -->
    @auth
    <div class="px-4 py-4 border-b border-gray-200 dark:border-gray-800">
        <a href="/profile" class="flex items-center space-x-3 p-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-all group">
            <div class="relative">
                <img src="{{ auth()->user()->avatar
                        ? asset('storage/' . auth()->user()->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=06b6d4&color=fff'
                    }}"
                     alt="Profile"
                     class="w-12 h-12 rounded-full ring-2 ring-gray-200 dark:ring-gray-700 group-hover:ring-cyan-500 transition-all">
                <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white dark:border-gray-900"></div>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-sm text-gray-900 dark:text-white truncate">
                    {{ auth()->user()->name }}
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                    {{ auth()->user()->username ?? strtolower(str_replace(' ', '', auth()->user()->name)) }}
                </p>
            </div>
            <i class="fa-solid fa-chevron-right text-gray-400 text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>
        </a>


    </div>
    @endauth

    <!-- Main Navigation -->
    <nav class="flex-1 px-3 py-4 overflow-y-auto hide-scrollbar">
        <div class="space-y-1">
            <!-- Beranda -->
            <a href="/"
               class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all
               {{ request()->is('/') || request()->is('/home')
                    ? 'bg-linear-to-r from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 text-cyan-600 dark:text-cyan-400 font-semibold shadow-sm'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800'
               }}">
                <div class="w-10 h-10 flex items-center justify-center rounded-xl {{ request()->is('/') || request()->is('/home') ? 'bg-cyan-500 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 group-hover:bg-gray-200 dark:group-hover:bg-gray-700' }} transition-colors">
                    <i class="fa-solid fa-house text-lg"></i>
                </div>
                <span class="text-sm font-medium">Beranda</span>
                @if(request()->is('/') || request()->is('/home'))
                <div class="ml-auto w-1.5 h-8 bg-cyan-500 rounded-full"></div>
                @endif
            </a>

            <!-- Pencarian -->
            <button id="search-toggle"
                    class="group w-full flex items-center space-x-3 px-3 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 group-hover:bg-gray-200 dark:group-hover:bg-gray-700 transition-colors">
                    <i class="fa-solid fa-magnifying-glass text-lg"></i>
                </div>
                <span class="text-sm font-medium">Pencarian</span>
                <i class="fa-solid fa-chevron-right text-xs text-gray-400 ml-auto opacity-0 group-hover:opacity-100 transition-opacity"></i>
            </button>

            <!-- Notifikasi -->
            <button id="notification-toggle"
                    class="group w-full flex items-center space-x-3 px-3 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 group-hover:bg-gray-200 dark:group-hover:bg-gray-700 transition-colors relative">
                    <i class="fa-solid fa-bell text-lg"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white dark:ring-gray-800"></span>
                </div>
                <span class="text-sm font-medium">Notifikasi</span>
                <div class="ml-auto flex items-center space-x-2">
                    <span class="px-2 py-0.5 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-xs font-semibold rounded-full">3</span>
                    <i class="fa-solid fa-chevron-right text-xs text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                </div>
            </button>

            <!-- Posting -->
            <a href="{{ route('posts.create') }}"
               class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all
               {{ request()->routeIs('posts.create')
                    ? 'bg-linear-to-r from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 text-cyan-600 dark:text-cyan-400 font-semibold shadow-sm'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800'
               }}">
                <div class="w-10 h-10 flex items-center justify-center rounded-xl {{ request()->routeIs('posts.create') ? 'bg-cyan-500 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 group-hover:bg-gray-200 dark:group-hover:bg-gray-700' }} transition-colors">
                    <i class="fa-solid fa-square-plus text-lg"></i>
                </div>
                <span class="text-sm font-medium">Buat Kampanye</span>
            </a>

            <!-- Divider -->
            <div class="py-2">
                <div class="border-t border-gray-200 dark:border-gray-800"></div>
            </div>

            <!-- Komunitas -->
            <a href="#"
               class="group flex items-center space-x-3 px-3 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 group-hover:bg-gray-200 dark:group-hover:bg-gray-700 transition-colors">
                    <i class="fa-solid fa-users text-lg"></i>
                </div>
                <span class="text-sm font-medium">Komunitas</span>
            </a>

            <!-- Tersimpan -->
            <a href="#"
               class="group flex items-center space-x-3 px-3 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 group-hover:bg-gray-200 dark:group-hover:bg-gray-700 transition-colors">
                    <i class="fa-solid fa-bookmark text-lg"></i>
                </div>
                <span class="text-sm font-medium">Tersimpan</span>
            </a>

            <!-- Riwayat -->
            <a href="#"
               class="group flex items-center space-x-3 px-3 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 group-hover:bg-gray-200 dark:group-hover:bg-gray-700 transition-colors">
                    <i class="fa-solid fa-clock-rotate-left text-lg"></i>
                </div>
                <span class="text-sm font-medium">Riwayat</span>
            </a>
        </div>
    </nav>

    <!-- Bottom Section -->
    <div class="px-3 py-4 border-t border-gray-200 dark:border-gray-800 space-y-1">
        <!-- Settings -->
        <a href="#"
           class="group flex items-center space-x-3 px-3 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 group-hover:bg-gray-200 dark:group-hover:bg-gray-700 transition-colors">
                <i class="fa-solid fa-gear text-lg"></i>
            </div>
            <span class="text-sm font-medium">Pengaturan</span>
        </a>

        <!-- Theme Toggle -->
        <button id="theme-toggle"
                class="group w-full flex items-center space-x-3 px-3 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 group-hover:bg-gray-200 dark:group-hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 hidden dark:block" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" />
                </svg>
                <svg class="w-5 h-5 block dark:hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                </svg>
            </div>
            <span class="text-sm font-medium">Tema</span>
            <span class="ml-auto text-xs text-gray-500 dark:text-gray-400">
                <span class="dark:hidden">Terang</span>
                <span class="hidden dark:inline">Gelap</span>
            </span>
        </button>

        @auth
        <!-- Logout -->
        <form method="POST" action="/logout">
            @csrf
            <button type="submit"
                    class="group w-full flex items-center space-x-3 px-3 py-3 rounded-xl text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all">
                <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 group-hover:bg-red-100 dark:group-hover:bg-red-900/30 transition-colors">
                    <i class="fa-solid fa-right-from-bracket text-lg"></i>
                </div>
                <span class="text-sm font-medium">Keluar</span>
            </button>
        </form>
        @endauth

        @guest
        <div class="space-y-2 pt-2">
            <a href="{{ route('login') }}"
               class="block w-full text-center px-4 py-2.5 bg-linear-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white text-sm font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all">
                Masuk
            </a>
            <a href="{{ route('register') }}"
               class="block w-full text-center px-4 py-2.5 border-2 border-cyan-500 text-cyan-600 dark:text-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 text-sm font-semibold rounded-xl transition-all">
                Daftar
            </a>
        </div>
        @endguest
    </div>
</div>

<!-- Search Panel (Instagram-style) -->
<div id="search-panel" class="hidden fixed left-64 top-0 h-screen w-96 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 shadow-2xl z-40">
    <div class="flex flex-col h-full">
        <div class="p-6 border-b border-gray-200 dark:border-gray-800">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Pencarian</h2>
                <button id="search-close" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="relative">
                <input type="text"
                       id="search-input"
                       placeholder="Cari kampanye atau pengguna..."
                       class="w-full px-4 py-3 pl-11 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-xl border-0 focus:ring-2 focus:ring-cyan-500 transition-all placeholder:text-gray-500">
                <i class="fa-solid fa-magnifying-glass text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
            </div>
        </div>
        <div class="flex-1 overflow-y-auto hide-scrollbar p-6">
            <div class="space-y-4">
                <div>
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Pencarian Terkini</h3>
                    <div class="text-center text-gray-400 dark:text-gray-500 py-8">
                        <i class="fa-solid fa-magnifying-glass text-3xl mb-2"></i>
                        <p class="text-sm">Belum ada riwayat pencarian</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notification Panel (Instagram-style) -->
<div id="notification-panel" class="hidden fixed left-64 top-0 h-screen w-96 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 shadow-2xl z-40">
    <div class="flex flex-col h-full">
        <div class="p-6 border-b border-gray-200 dark:border-gray-800">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Notifikasi</h2>
                <button id="notification-close" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
        </div>
        <div class="flex-1 overflow-y-auto hide-scrollbar">
            <div class="text-center text-gray-400 dark:text-gray-500 py-12 px-6">
                <i class="fa-solid fa-bell text-4xl mb-3"></i>
                <p class="text-sm font-medium mb-1">Belum ada notifikasi</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Notifikasi Anda akan muncul di sini</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Theme Toggle
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        const html = document.documentElement;
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            html.classList.add('dark');
        }

        themeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
        });
    }

    // Search Panel Toggle
    const searchToggle = document.getElementById('search-toggle');
    const searchPanel = document.getElementById('search-panel');
    const searchClose = document.getElementById('search-close');
    const notificationToggle = document.getElementById('notification-toggle');
    const notificationPanel = document.getElementById('notification-panel');
    const notificationClose = document.getElementById('notification-close');

    searchToggle?.addEventListener('click', () => {
        searchPanel.classList.toggle('hidden');
        notificationPanel?.classList.add('hidden');
    });

    searchClose?.addEventListener('click', () => {
        searchPanel?.classList.add('hidden');
    });

    notificationToggle?.addEventListener('click', () => {
        notificationPanel.classList.toggle('hidden');
        searchPanel?.classList.add('hidden');
    });

    notificationClose?.addEventListener('click', () => {
        notificationPanel?.classList.add('hidden');
    });

    // Close panels when clicking outside
    document.addEventListener('click', (e) => {
        if (!searchPanel?.contains(e.target) && !searchToggle?.contains(e.target)) {
            searchPanel?.classList.add('hidden');
        }
        if (!notificationPanel?.contains(e.target) && !notificationToggle?.contains(e.target)) {
            notificationPanel?.classList.add('hidden');
        }
    });
});
</script>
