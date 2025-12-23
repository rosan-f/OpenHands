 <aside
     class="hidden lg:flex flex-col fixed left-0 top-0 h-screen w-72 border-r border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 z-40">
     <div class="flex flex-col h-full">
         <!-- Logo  -->
         <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800">
             <a href="/" class="flex items-center space-x-3 group">
                 <div class="relative">
                     <div
                         class="w-12 h-12 flex items-center justify-center  group-hover:shadow-xl transition-shadow">
                        <img src="{{asset('images/logo.svg')}}" alt="">
                     </div>

                 </div>
                 <div class="flex-1">
                     <h1 class="text-xl font-bold text-gray-900 dark:text-white tracking-tight">OpenHands</h1>
                 </div>
             </a>
         </div>

         <!-- Main Navigation -->
         <nav class="flex-1 px-3 py-4 overflow-y-auto hide-scrollbar">
             <div class="space-y-1">
                 <!-- Beranda -->
                 <a href="/"
                     class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all
               {{ request()->is('/')
                   ? 'bg-linear-to-r from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 text-cyan-600 dark:text-cyan-400 font-semibold shadow-sm'
                   : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                     <div
                         class="w-10 h-10 flex items-center justify-center rounded-xl {{ request()->is('/')
                             ? 'bg-cyan-500 text-white'
                             : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 group-hover:bg-gray-200 dark:group-hover:bg-gray-700' }} transition-colors">
                         <i class="fa-solid fa-house text-lg"></i>
                     </div>
                     <span class="text-sm font-medium">Beranda</span>
                 </a>

                 <!-- Notifikasi -->
                 @auth
                     <a href="{{ route('notifications.index') }}"
                         class="group w-full flex items-center space-x-3 px-3 py-3 rounded-xl transition-all
                         {{ request()->routeIs('notifications.index') ?
                          'bg-linear-to-r from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 text-cyan-600 dark:text-cyan-400 font-semibold shadow-sm':
                        'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                         <div
                             class="w-10 h-10 flex items-center justify-center rounded-xl {{ request()->routeIs('notifications.index') ? 'bg-cyan-500 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 group-hover:bg-gray-200 dark:group-hover:bg-gray-700' }} transition-colors relative">
                             <i class="fa-solid fa-bell text-lg"></i>

                             @if (auth()->user()->unread_notifications_count > 0)
                                 <span
                                     class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 rounded-full ring-2 ring-white dark:ring-gray-900 animate-pulse"></span>
                             @endif

                         </div>
                         <span class="text-sm font-medium">Notifikasi</span>
                         <div class="ml-auto flex items-center space-x-2">
                             @if (auth()->user()->unread_notifications_count > 0)
                                 <span
                                     class="notification-badge px-2 py-0.5 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-xs font-semibold rounded-full">
                                     {{ auth()->user()->unread_notifications_count }}
                                 </span>
                             @endif
                         </div>
                     </a>
                 @else
                     <button id="notification-toggle"
                         class="group w-full flex items-center space-x-3 px-3 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                         <div
                             class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 group-hover:bg-gray-200 dark:group-hover:bg-gray-700 transition-colors">
                             <i class="fa-solid fa-bell text-lg"></i>
                         </div>
                         <span class="text-sm font-medium">Notifikasi</span>
                     </button>
                 @endauth

                 <!-- Buat Kampanye -->
                 <a href="{{ route('posts.create') }}"
                     class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all

               {{ request()->routeIs('posts.create')
                   ? 'bg-linear-to-r from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 text-cyan-600 dark:text-cyan-400 font-semibold shadow-sm'
                   : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">

                     <div
                         class="w-10 h-10 flex items-center justify-center rounded-xl {{ request()->routeIs('posts.create') ? 'bg-cyan-500 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 group-hover:bg-gray-200 dark:group-hover:bg-gray-700' }} transition-colors">
                         <i class="fa-solid fa-square-plus text-lg"></i>
                     </div>
                     <span class="text-sm font-medium">Buat Kampanye</span>
                 </a>

                 <!-- Divider -->
                 <div class="py-2">
                     <div class="border-t border-gray-200 dark:border-gray-800"></div>
                 </div>

                 <!-- Tersimpan -->
                 <a href="{{ route('bookmarks.index') }}"
                     class="group flex items-center space-x-3 px-3 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all

                           {{ request()->routeIs('posts.saved')
                               ? 'bg-linear-to-r from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 text-cyan-600 dark:text-cyan-400 font-semibold shadow-sm'
                               : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                     <div
                         class="w-10 h-10 flex items-center justify-center rounded-xl {{ request()->routeIs('posts.saved')
                             ? 'bg-cyan-500 text-white'
                             : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 group-hover:bg-gray-200 dark:group-hover:bg-gray-700' }} transition-colors">
                         <i class="fa-solid fa-bookmark text-lg"></i>
                     </div>
                     <span class="text-sm font-medium">Tersimpan</span>
                 </a>

                 {{-- history --}}

                 <a href="{{ route('donations.history') }}"
                     class="group flex items-center space-x-3 px-3 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all
                           {{ request()->routeIs('donations.history')
                               ? 'bg-linear-to-r from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 text-cyan-600 dark:text-cyan-400 font-semibold shadow-sm'
                               : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                     <div
                         class="w-10 h-10 flex items-center justify-center rounded-xl {{ request()->routeIs('donations.history')
                             ? 'bg-cyan-500 text-white'
                             : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 group-hover:bg-gray-200 dark:group-hover:bg-gray-700' }} transition-colors">

                         <i class="fa-solid fa-clock-rotate-left mr-1"></i>

                     </div>
                     <span class="text-sm font-medium">Riwayat</span>
                 </a>

             </div>
         </nav>

         <!-- User Profile  -->
         @auth
             <div class="px-3 py-4 border-t border-gray-200 dark:border-gray-800">
                 <div class="relative">
                     <div id="profile-dropup"
                         class="hidden absolute bottom-full left-0 right-0 mb-2 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-200 opacity-0 translate-y-4">

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

                         <!-- Theme  -->
                         <button id="theme-toggle"
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
                                 <div
                                     class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-50 dark:bg-red-900/20">
                                     <i class="fa-solid fa-right-from-bracket text-red-600 dark:text-red-400"></i>
                                 </div>
                                 <span class="text-sm font-medium text-red-600 dark:text-red-400">Keluar</span>
                             </button>
                         </form>
                     </div>

                     <!-- Profile Button -->
                     <button id="profile-toggle-btn"
                         class="w-full flex items-center space-x-3 p-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-all group">
                         <div class="relative">

                             <img src="{{ auth()->user()->avatar
                                 ? asset('storage/' . auth()->user()->avatar)
                                 : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=06b6d4&color=fff' }}"

                                 class="w-10 h-10 rounded-full ring-2 ring-gray-200 dark:ring-gray-700 group-hover:ring-cyan-500 transition-all">

                         </div>
                         <div class="flex-1 min-w-0 text-left">
                             <h3 class="font-semibold text-sm text-gray-900 dark:text-white truncate">
                                 {{ auth()->user()->name }}
                             </h3>
                             <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                 {{ auth()->user()->username ?? strtolower(str_replace(' ', '', auth()->user()->name)) }}
                             </p>
                         </div>
                         <i id="profile-toggle-icon"
                             class="fa-solid fa-chevron-up text-gray-400 transition-transform duration-200"></i>
                     </button>
                 </div>
             </div>
         @else
             <div class="px-3 py-4 border-t border-gray-200 dark:border-gray-800 space-y-2">
                 <a href="{{ route('login') }}"
                     class="block w-full text-center px-4 py-2.5 bg-linear-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white text-sm font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all">
                     Masuk
                 </a>
                 <a href="{{ route('register') }}"
                     class="block w-full text-center px-4 py-2.5 border-2 border-cyan-500 text-cyan-600 dark:text-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 text-sm font-semibold rounded-xl transition-all">
                     Daftar
                 </a>
             </div>
         @endauth
     </div>
 </aside>

 <script>
     document.addEventListener('DOMContentLoaded', function() {
         const profileToggleBtn = document.getElementById('profile-toggle-btn');
         const profileDropup = document.getElementById('profile-dropup');
         const profileToggleIcon = document.getElementById('profile-toggle-icon');

         if (profileToggleBtn && profileDropup && profileToggleIcon) {
             profileToggleBtn.addEventListener('click', function() {
                 const isHidden = profileDropup.classList.contains('hidden');

                 if (isHidden) {
                     profileDropup.classList.remove('hidden');
                     setTimeout(() => {
                         profileDropup.classList.remove('opacity-0', 'translate-y-4');
                         profileDropup.classList.add('opacity-100', 'translate-y-0');
                     }, 10);

                     profileToggleIcon.classList.remove('fa-chevron-up', 'text-gray-400');
                     profileToggleIcon.classList.add('fa-chevron-down', 'text-gray-600',
                         'dark:text-gray-300');
                 } else {
                     profileDropup.classList.remove('opacity-100', 'translate-y-0');
                     profileDropup.classList.add('opacity-0', 'translate-y-4');
                     setTimeout(() => {
                         profileDropup.classList.add('hidden');
                     }, 200);

                     profileToggleIcon.classList.remove('fa-chevron-down', 'text-gray-600',
                         'dark:text-gray-300');
                     profileToggleIcon.classList.add('fa-chevron-up', 'text-gray-400');
                 }
             });

             document.addEventListener('click', function(event) {
                 if (!profileToggleBtn.contains(event.target) && !profileDropup.contains(event.target)) {
                     if (!profileDropup.classList.contains('hidden')) {
                         profileDropup.classList.remove('opacity-100', 'translate-y-0');
                         profileDropup.classList.add('opacity-0', 'translate-y-4');
                         setTimeout(() => {
                             profileDropup.classList.add('hidden');
                         }, 200);

                         profileToggleIcon.classList.remove('fa-chevron-down', 'text-gray-600',
                             'dark:text-gray-300');
                         profileToggleIcon.classList.add('fa-chevron-up', 'text-gray-400');
                     }
                 }
             });
         }

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

         // Auto refresh notif
         @auth
         setInterval(function() {
             fetch('{{ route('notifications.unreadCount') }}')
                 .then(response => response.json())
                 .then(data => {
                     const badge = document.querySelector('.notification-badge');
                     if (data.count > 0) {
                         if (badge) {
                             badge.textContent = data.count;
                         }
                     } else {
                         if (badge) {
                             badge.remove();
                         }
                     }
                 })
                 .catch(error => console.error('Error:', error));
         }, 30000);
     @endauth
     });
 </script>
