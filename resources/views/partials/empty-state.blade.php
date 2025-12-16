<div class="py-12 px-4">
    <div class="flex flex-col items-center justify-center space-y-6 max-w-md mx-auto text-center">
        <div class="w-24 h-24 bg-linear-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 rounded-full flex items-center justify-center">
            <svg class="w-12 h-12 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
        </div>

        <!-- Empty State Text -->
        <div class="space-y-2">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                Belum Ada Postingan
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Saat ini belum ada kampanye donasi yang tersedia. Jadilah yang pertama untuk membuat kampanye dan membantu mereka yang membutuhkan!
            </p>
        </div>

        <!-- Call to Action -->
        <div class="flex flex-col gap-3 w-full">
            <a href="{{ route('posts.create') }}"
               class="w-full px-6 py-3 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded-lg transition-colors flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Buat Kampanye Pertama</span>
            </a>

            <button onclick="window.location.reload()"
                    class="w-full px-6 py-3 text-gray-700 dark:text-gray-300 font-medium border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>Refresh Halaman</span>
            </button>
        </div>

        <!-- Additional Info -->
        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-800 w-full">
            <div class="flex justify-around text-center">
                <div class="space-y-1">
                    <div class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">0</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">Kampanye</div>
                </div>
                <div class="space-y-1">
                    <div class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">0</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">Donatur</div>
                </div>
                <div class="space-y-1">
                    <div class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">Rp 0</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">Terkumpul</div>
                </div>
            </div>
        </div>
    </div>
</div>
