@extends('layouts.app')
@section('title', 'Donasi ' . $post->title)
@section('content')

        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <a href="{{ route('posts.show', $post) }}"
                class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white mb-6 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke kampanye
            </a>


            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <div class="flex items-start space-x-4">
                    @if ($post->images && count($post->images) > 0)
                        <div class="shrink-0">
                            <img src="{{ asset('storage/' . $post->images[0]) }}" alt="{{ $post->title }}"
                                class="w-16 h-16 object-cover rounded-lg">
                        </div>
                    @endif
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white line-clamp-2">{{ $post->title }}
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            oleh {{ $post->user->name ?? 'Anonymous' }}
                        </p>
                    </div>
                </div>

                @php
                    $percentage =
                        $post->target_amount > 0 ? min(($post->collected_amount / $post->target_amount) * 100, 100) : 0;
                @endphp

                <div class="mt-4 space-y-2">
                    <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                        <span>Terkumpul</span>
                        <span>Rp {{ number_format($post->collected_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-linear-to-r from-cyan-500 to-cyan-600 h-2 rounded-full transition-all duration-500"
                            style="width: {{ $percentage }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                        <span>Target: Rp {{ number_format($post->target_amount, 0, ',', '.') }}</span>
                        <span>{{ number_format($percentage, 1) }}% tercapai</span>
                    </div>
                </div>
            </div>

            {{-- from --}}
            <form action="{{ route('donations.store', $post) }}" method="POST">
                @csrf

                {{-- error message --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle text-red-500 mt-0.5 mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-red-800 dark:text-red-200">Mohon perbaiki data
                                    berikut:</p>
                                <ul class="mt-1 text-sm text-red-700 dark:text-red-300 list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- donation --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Donasi untuk Kampanye Ini</h3>

                    {{-- ammount --}}
                    <div class="mb-6">
                        <label for="amount" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                            Nominal Donasi
                        </label>
                        <div class="relative">
                            <span
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">Rp</span>
                            <input type="number" name="amount" id="amount" value="{{ old('amount') }}" min="10000"
                                step="1000"
                                class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white"
                                placeholder="Contoh: 50000" required>
                        </div>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Minimal donasi: Rp 10.000</p>
                    </div>

                    {{-- payment method --}}
                    <div class="mb-6">
                        <label for="payment_method" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                            Metode Pembayaran
                        </label>
                        <div class="relative">
                            <select name="payment_method" id="payment_method"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white appearance-none"
                                required>
                                <option value="">Pilih metode pembayaran</option>
                                <option value="manual_transfer"
                                    {{ old('payment_method') == 'manual_transfer' ? 'selected' : '' }}>
                                    Transfer Manual (Bank/QRIS)
                                </option>
                                <option value="wallet" {{ old('payment_method') == 'wallet' ? 'selected' : '' }}>
                                    E-Wallet (GoPay, OVO, DANA)
                                </option>
                                <option value="virtual_account"
                                    {{ old('payment_method') == 'virtual_account' ? 'selected' : '' }}>
                                    Virtual Account (BCA, BNI, Mandiri)
                                </option>
                            </select>
                            <i
                                class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                        </div>
                        @error('payment_method')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- message --}}
                    <div class="mb-6">
                        <label for="message" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                            Pesan Dukungan (Opsional)
                        </label>
                        <textarea name="message" id="message" rows="2"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white resize-none">{{ old('message') }}</textarea>
                    </div>



                    {{-- actions --}}
                    <div class="flex flex-col sm:flex-row sm:justify-end gap-3">
                        <a href="{{ route('posts.show', $post) }}"
                            class="px-6 py-2.5 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg font-medium text-center transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 bg-linear-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200">
                            <i class="fas fa-hand-holding-heart mr-2"></i>Donasi Sekarang
                        </button>
                    </div>
                </div>
            </form>
        </div>


@endsection
