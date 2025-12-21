<!-- Mobile Bottom Navigation -->
<nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 z-50">
    <div class="flex items-center justify-around h-16 px-2">
        <!-- Home -->
        <a href="/"
           class="flex flex-col items-center justify-center flex-1 h-full group">
            <div class="relative">
                <i class="fa-solid fa-house text-2xl {{ request()->is('/') ? 'text-cyan-600 dark:text-cyan-400' : 'text-gray-500 dark:text-gray-400' }} transition-colors"></i>
            </div>
        </a>

        <!-- Notifications -->
        @auth
        <a href="{{ route('notifications.index') }}"
           class="flex flex-col items-center justify-center flex-1 h-full relative group">
            <div class="relative">
                <i class="fa-solid fa-bell text-2xl {{ request()->routeIs('notifications.index') ? 'text-cyan-600 dark:text-cyan-400' : 'text-gray-500 dark:text-gray-400' }} transition-colors"></i>

                @if(auth()->user()->unread_notifications_count > 0)
                <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs flex items-center justify-center rounded-full font-bold">
                    {{ auth()->user()->unread_notifications_count > 9 ? '9+' : auth()->user()->unread_notifications_count }}
                </span>
                @endif

            </div>
        </a>
        @endauth

        <!-- Create  -->
        <a href="{{ route('posts.create') }}"
           class="flex flex-col items-center justify-center flex-1 h-full -mt-6">
            <div class="w-14 h-14 bg-linear-to-br from-cyan-500 to-cyan-600 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all hover:scale-105">
                <i class="fa-solid fa-plus text-white text-xl"></i>
            </div>
        </a>

        <!-- Saved -->
        <a href="#"
           class="flex flex-col items-center justify-center flex-1 h-full group">
            <div class="relative">
                <i class="fa-regular fa-bookmark text-2xl {{ request()->routeIs('saved.index') ? 'text-cyan-600 dark:text-cyan-400' : 'text-gray-500 dark:text-gray-400' }} transition-colors"></i>
            </div>
        </a>

        <!-- Donation History -->
        <a href="{{ route('donations.history') }}"
           class="flex flex-col items-center justify-center flex-1 h-full group">
            <div class="relative">
                <i class="fa-solid fa-clock-rotate-left text-2xl{{ request()->routeIs('donations.history') ? 'text-cyan-600 dark:text-cyan-400' : 'text-gray-500 dark:text-gray-400' }} transition-colors"></i>

            </div>
        </a>
    </div>
</nav>
