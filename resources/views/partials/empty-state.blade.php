<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
    <div class="flex flex-col items-center justify-center space-y-4">
        <!-- Empty State Icon -->
        <div class="w-24 h-24 bg-linear-to-br from-cyan-100 to-cyan-200 dark:from-cyan-900 dark:to-cyan-800 rounded-full flex items-center justify-center">
            <svg class="w-12 h-12 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
        </div>

        <!-- Empty State Text -->
        <div class="space-y-2">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                Belum Ada Postingan
            </h3>
            <p class="text-gray-600 dark:text-gray-400 max-w-md">
                Saat ini belum ada kampanye donasi yang tersedia. Jadilah yang pertama untuk membuat kampanye dan membantu mereka yang membutuhkan!
            </p>
        </div>

        <!-- Call to Action -->
        <div class="flex flex-col sm:flex-row gap-3 mt-6">
            <button class="px-6 py-3 bg-linear-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Buat Kampanye Pertama</span>
            </button>

            <button class="px-6 py-3 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>Refresh Halaman</span>
            </button>
        </div>

        <!-- Additional Info -->
        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700 w-full">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">
                <div class="space-y-1">
                    <div class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">0</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Kampanye Aktif</div>
                </div>
                <div class="space-y-1">
                    <div class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">0</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Total Donatur</div>
                </div>
                <div class="space-y-1">
                    <div class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">Rp 0</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Dana Terkumpul</div>
                </div>
            </div>
        </div>
    </div>
</div>
