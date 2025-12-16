@extends('layouts.app')

@section('title', 'Donasi untuk ' . $post->title)

@section('content')
<div class="min-h-screen bg-white dark:bg-gray-900 transition-colors duration-200">
    <div class="flex">
        <!-- Sidebar Kiri - Desktop Only -->
        <aside class="hidden lg:flex flex-col fixed left-0 top-0 h-screen w-64 border-r border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 z-40">
            @include('partials.sidebar-left')
        </aside>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-64 pb-16 lg:pb-0">
            <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

                <!-- Back to Post -->
                <a href="{{ route('posts.show', $post) }}"
                    class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white mb-6 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke kampanye
                </a>

                <!-- Campaign Summary Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                    <div class="flex items-start space-x-4">
                        @if ($post->images && count($post->images) > 0)
                            <div class="flex-shrink-0">
                                <img src="{{ asset('storage/' . $post->images[0]) }}"
                                     alt="{{ $post->title }}"
                                     class="w-16 h-16 object-cover rounded-lg">
                            </div>
                        @endif
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white line-clamp-2">{{ $post->title }}</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                oleh {{ $post->user->name ?? 'Anonymous' }}
                            </p>
                        </div>
                    </div>

                    <!-- Progress -->
                    @php
                        $percentage = $post->target_amount > 0 ? min(($post->current_amount / $post->target_amount) * 100, 100) : 0;
                    @endphp
                    <div class="mt-4 space-y-2">
                        <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                            <span>Terkumpul</span>
                            <span>Rp {{ number_format($post->current_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-linear-to-r from-cyan-500 to-cyan-600 h-2 rounded-full transition-all duration-500"
                                 style="width: {{ $percentage }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                            <span>Target: Rp {{ number, no thousands separator, etc. }}
                            <span>{{ number_format($percentage, 1) }}% tercapai</span>
                        </div>
                    </div>
                </div>

                <!-- Donation Form -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Donasi untuk Kampanye Ini</h3>

                    <!-- Amount Input -->
                    <div class="mb-6">
                        <label for="amount" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                            Nominal Donasi
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 font-medium">Rp</span>
                            <input
                                type="number"
                                id="amount"
                                value="50000"
                                min="10000"
                                step="1000"
                                class="w-full pl-12 pr-4 py-3.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white"
                                placeholder="Masukkan nominal"
                            >
                        </div>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach ([50000, 100000, 250000, 500000] as $nominal)
                                <button type="button"
                                    class="px-3 py-1.5 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-cyan-100 dark:hover:bg-cyan-900/30 hover:text-cyan-700 dark:hover:text-cyan-300 transition-colors">
                                    Rp {{ number_format($nominal, 0, ',', '.') }}
                                </button>
                            @endforeach
                        </div>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Minimal donasi: Rp 10.000</p>
                    </div>

                    <!-- Message (Optional) -->
                    <div class="mb-6">
                        <label for="message" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                            Pesan (Opsional)
                        </label>
                        <textarea
                            id="message"
                            rows="2"
                            placeholder="Tulis pesan dukungan untuk pembuat kampanye..."
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white resize-none"
                        ></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-col sm:flex-row sm:justify-end gap-3">
                        <a href="{{ route('posts.show', $post) }}"
                            class="px-6 py-2.5 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg font-medium text-center transition-colors">
                            Batal
                        </a>
                        <button
                            type="button"
                            onclick="alert('Fitur donasi dalam mode demo.\\n\\nPost ID: {{ $post->id }}\\nNominal: Rp ' + document.getElementById('amount').value);"
                            class="px-6 py-2.5 bg-linear-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200">
                            <i class="fas fa-hand-holding-heart mr-2"></i>Donasi Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
