<div class="space-y-4 sticky top-20">

    <!-- Profile Card -->
    @auth
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center space-x-3">
            <img
                src="{{ auth()->user()->avatar
                    ? asset('storage/' . auth()->user()->avatar)
                    : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=06b6d4&color=fff'
                }}"
                alt="Profile"
                class="w-12 h-12 rounded-full"
            >

            <div class="flex-1">
                <h3 class="font-semibold text-gray-900 dark:text-white">
                    {{ auth()->user()->name }}
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ auth()->user()->name ?? 'user' }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-2 mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 text-center">
            <div>
                <div class="text-lg font-bold text-gray-900 dark:text-white">12</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Kampanye</div>
            </div>
            <div>
                <div class="text-lg font-bold text-gray-900 dark:text-white">48</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Donasi</div>
            </div>
            <div>
                <div class="text-lg font-bold text-cyan-600 dark:text-cyan-400">5.2M</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Impact</div>
            </div>
        </div>
    </div>
    @endauth

    <!-- Quick Menu -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <nav class="space-y-1 p-2">

            <!-- Beranda -->
            <a href="/"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium
               {{ request()->is('/home')
                    ? 'text-cyan-600 dark:text-cyan-400 bg-cyan-50 dark:bg-cyan-900/20'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
               }}">
                <i class="fa-solid fa-house w-5"></i>
                <span>Beranda</span>
            </a>

            <!-- Posting -->
            <a href="{{ route('posts.create') }}"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg font-medium
               {{ request()->routeIs('posts.create')
                    ? 'text-cyan-600 dark:text-cyan-400 bg-cyan-50 dark:bg-cyan-900/20'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
               }}">
                <i class="fa-solid fa-pen-to-square w-5"></i>
                <span>Posting</span>
            </a>

            <!-- Komunitas -->
            <a href="#"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg
               text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fa-solid fa-users w-5"></i>
                <span>Komunitas</span>
            </a>

            <!-- Tersimpan -->
            <a href="#"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg
               text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fa-solid fa-bookmark w-5"></i>
                <span>Tersimpan</span>
            </a>



            <!-- Riwayat -->
            <a href="#"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg
               text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fa-solid fa-clock-rotate-left w-5"></i>
                <span>Riwayat</span>
            </a>

            <!-- Pengaturan -->
            <a href="#"
               class="flex items-center space-x-3 px-3 py-2 rounded-lg
               text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fa-solid fa-gear w-5"></i>
                <span>Pengaturan</span>
            </a>

        </nav>
    </div>

    <!-- Categories -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
    <h3 class="font-semibold text-gray-900 dark:text-white mb-3">
        Kategori Populer
    </h3>

    @if($popularCategories->count())
        <div class="space-y-2">
            @foreach($popularCategories as $category)
                <a href=""
                   class="flex items-center justify-between px-3 py-2 text-sm
                   text-gray-700 dark:text-gray-300
                   hover:bg-gray-100 dark:hover:bg-gray-700
                   rounded-lg transition-colors">

                    <span>{{ $category->name }}</span>

                    <span class="text-xs text-gray-500">
                        {{ $category->posts_count }}
                    </span>
                </a>
            @endforeach
        </div>
    @else
        <div class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">
            Belum ada postingan
        </div>
    @endif
</div>



</div>
