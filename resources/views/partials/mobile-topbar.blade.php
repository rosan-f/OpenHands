<!-- Mobile Top Navigation -->
<nav class="lg:hidden fixed top-0 left-0 right-0 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 z-50">
    <div class="flex items-center justify-between px-4 py-3">
        <!-- Logo -->
        <a href="/" class="flex items-center space-x-2">
            <div class="w-9 h-9 bg-linear-to-br from-cyan-500 to-cyan-600 rounded-lg flex items-center justify-center shadow-md">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" />
                </svg>
            </div>
            <div>
                <h1 class="text-base font-bold text-gray-900 dark:text-white">OpenHands</h1>
            </div>
        </a>

        <!-- Profile Dropdown -->
        @auth
        <div class="relative">
            <!-- Dropdown Menu-->
            <div id="mobile-profile-dropdown"
                 class="hidden absolute top-10 right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-200 opacity-0 translate-y-2">

                <!-- Profile Link -->
                <a href="/profile"
                   class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700">
                        <i class="fa-solid fa-user text-gray-600 dark:text-gray-400"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Profil</span>
                </a>

                <!-- Settings -->
                <a href="#"
                   class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700">
                        <i class="fa-solid fa-gear text-gray-600 dark:text-gray-400"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Pengaturan</span>
                </a>

                <!-- Theme Toggle -->
                <button id="mobile-theme-toggle"
                        class="w-full flex items-center space-x-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700">
                        <i class="fa-solid fa-moon hidden dark:block text-gray-600 dark:text-gray-400"></i>
                        <i class="fa-solid fa-sun block dark:hidden text-gray-600 dark:text-gray-400"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tema</span>
                    <span class="ml-auto text-xs text-gray-500 dark:text-gray-400">
                        <span class="dark:hidden">Terang</span>
                        <span class="hidden dark:inline">Gelap</span>
                    </span>
                </button>

                <!-- Divider -->
                <div class="border-t border-gray-200 dark:border-gray-700"></div>

                <!-- Logout -->
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center space-x-3 px-4 py-3 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                        <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-50 dark:bg-red-900/20">
                            <i class="fa-solid fa-right-from-bracket text-red-600 dark:text-red-400"></i>
                        </div>
                        <span class="text-sm font-medium text-red-600 dark:text-red-400">Keluar</span>
                    </button>
                </form>
            </div>

            <!-- Profile Button -->
            <button id="mobile-profile-toggle-btn"
                    class="flex items-center space-x-2 p-1.5 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-all group">
                <div class="flex items-center space-x-2">
                    <span class="text-sm font-medium text-gray-900 dark:text-white max-w-25 truncate">
                        {{ auth()->user()->name }}
                    </span>
                    <div class="relative">
                        <img src="{{ auth()->user()->avatar
                                ? asset('storage/' . auth()->user()->avatar)
                                : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=06b6d4&color=fff'
                            }}"
                             alt="Profile"
                             class="w-9 h-9 rounded-full ring-2 ring-gray-200 dark:ring-gray-700 group-hover:ring-cyan-500 transition-all">
                        <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-white dark:border-gray-900"></div>
                    </div>
                </div>
                <i id="mobile-profile-toggle-icon" class="fa-solid fa-chevron-down text-gray-400 text-xs transition-transform duration-200"></i>
            </button>
        </div>
        @else
        <div class="flex items-center space-x-2">
            <a href="{{ route('login') }}"
               class="px-4 py-2 text-sm font-medium text-cyan-600 dark:text-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 rounded-lg transition-all">
                Masuk
            </a>
            <a href="{{ route('register') }}"
               class="px-4 py-2 text-sm font-medium bg-linear-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all">
                Daftar
            </a>
        </div>
        @endauth
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Profile Dropdown
    const mobileProfileToggleBtn = document.getElementById('mobile-profile-toggle-btn');
    const mobileProfileDropdown = document.getElementById('mobile-profile-dropdown');
    const mobileProfileToggleIcon = document.getElementById('mobile-profile-toggle-icon');

    if (mobileProfileToggleBtn && mobileProfileDropdown && mobileProfileToggleIcon) {
        mobileProfileToggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            const isHidden = mobileProfileDropdown.classList.contains('hidden');

            if (isHidden) {
                mobileProfileDropdown.classList.remove('hidden');
                setTimeout(() => {
                    mobileProfileDropdown.classList.remove('opacity-0', 'translate-y-2');
                    mobileProfileDropdown.classList.add('opacity-100', 'translate-y-0');
                }, 10);

                mobileProfileToggleIcon.classList.add('rotate-180');
            } else {
                mobileProfileDropdown.classList.remove('opacity-100', 'translate-y-0');
                mobileProfileDropdown.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => {
                    mobileProfileDropdown.classList.add('hidden');
                }, 200);

                mobileProfileToggleIcon.classList.remove('rotate-180');
            }
        });

        document.addEventListener('click', function(event) {
            if (!mobileProfileToggleBtn.contains(event.target) &&
                !mobileProfileDropdown.contains(event.target)) {
                if (!mobileProfileDropdown.classList.contains('hidden')) {
                    mobileProfileDropdown.classList.remove('opacity-100', 'translate-y-0');
                    mobileProfileDropdown.classList.add('opacity-0', 'translate-y-2');
                    setTimeout(() => {
                        mobileProfileDropdown.classList.add('hidden');
                    }, 200);

                    mobileProfileToggleIcon.classList.remove('rotate-180');
                }
            }
        });
    }

    // theme
    const mobileThemeToggle = document.getElementById('mobile-theme-toggle');
    if (mobileThemeToggle) {
        const html = document.documentElement;

        mobileThemeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
        });
    }
});
</script>
