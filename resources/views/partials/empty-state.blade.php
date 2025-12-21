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
                Saat ini belum ada kampanye donasi yang tersedia. Jadilah yang pertama untuk membuat kampanye dan membantu mereka yang membutuhkan
            </p>
        </div>

        <!-- Cta -->
        <div class="flex flex-col gap-3 w-full">
            <a href="{{ route('posts.create') }}"
               class="w-full px-6 py-3 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded-lg transition-colors flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Buat Kampanye Pertama</span>
            </a>

        </div>


        </div>
    </div>
</div>
