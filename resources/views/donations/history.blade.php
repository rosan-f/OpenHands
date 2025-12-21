@extends('layouts.app')
@section('title', 'Riwayat Donasi')
@section('content')


            <div class="max-w-4xl mx-auto px-4 py-8">
                {{-- header --}}
                <div class="mb-8">
                    <div class="flex items-center space-x-4 mb-2">
                        <a href="{{ route('profile.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                            <i class="fa-solid fa-arrow-left text-xl"></i>
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Riwayat Donasi</h1>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Semua donasi yang telah Anda berikan</p>
                </div>

                {{-- stats --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="bg-linear-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 rounded-xl p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Donasi</span>
                            <i class="fa-solid fa-hand-holding-heart text-cyan-600 dark:text-cyan-400 text-xl"></i>
                        </div>
                        <div class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">
                            Rp {{ number_format($stats['total_donated'], 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="bg-linear-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 rounded-xl p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Jumlah Transaksi</span>
                            <i class="fa-solid fa-receipt text-cyan-600 dark:text-cyan-400 text-xl"></i>
                        </div>
                        <div class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">
                            {{ $stats['total_donations'] }}
                        </div>
                    </div>

                    <div class="bg-linear-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 rounded-xl p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Bulan Ini</span>
                            <i class="fa-solid fa-calendar text-cyan-600 dark:text-cyan-400 text-xl"></i>
                        </div>
                        <div class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">
                            Rp {{ number_format($stats['this_month'], 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                {{-- donation list --}}
                <div class="space-y-4">
                    @forelse($donations as $donation)
                    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-start space-x-4">

                            {{-- image --}}
                            @if($donation->post->images && count($donation->post->images) > 0)
                            <img src="{{ asset('storage/' . $donation->post->images[0]) }}"
                                 alt="{{ $donation->post->title }}"
                                 class="w-20 h-20 rounded-lg object-cover">
                            @else
                            <div class="w-20 h-20 bg-linear-to-br from-cyan-100 to-cyan-200 dark:from-cyan-900/20 dark:to-cyan-800/20 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-hand-holding-heart text-cyan-600 dark:text-cyan-400 text-2xl"></i>
                            </div>
                            @endif

                            {{-- info --}}
                            <div class="flex-1">
                                <a href="{{ route('posts.show', $donation->post->id) }}" class="font-semibold text-gray-900 dark:text-white hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
                                    {{ $donation->post->title }}
                                </a>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Kepada: <span class="font-medium">{{ $donation->post->user->name }}</span>
                                </p>

                                @if($donation->message)
                                <div class="mt-2 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        <i class="fa-solid fa-quote-left text-gray-400 mr-1"></i>
                                        {{ $donation->message }}
                                    </p>
                                </div>
                                @endif

                                <div class="flex items-center space-x-4 mt-3 text-xs text-gray-500 dark:text-gray-400">
                                    <span>
                                        <i class="fa-solid fa-calendar-day mr-1"></i>
                                        {{ $donation->created_at->format('d M Y') }}
                                    </span>
                                    <span>
                                        <i class="fa-solid fa-clock mr-1"></i>
                                        {{ $donation->created_at->format('H:i') }}
                                    </span>
                                    @if($donation->is_anonymous)
                                    <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-800 rounded-full">
                                        <i class="fa-solid fa-user-secret mr-1"></i> Anonim
                                    </span>
                                    @endif
                                </div>
                            </div>

                           {{-- ammount --}}
                            <div class="text-right">
                                <div class="text-xl font-bold text-cyan-600 dark:text-cyan-400">
                                    Rp {{ number_format($donation->amount, 0, ',', '.') }}
                                </div>
                                <span class="inline-block mt-1 px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-xs font-semibold rounded-full">
                                    <i class="fa-solid fa-check-circle mr-1"></i> Sukses
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-16">
                        <i class="fa-solid fa-hand-holding-heart text-6xl text-gray-300 dark:text-gray-700 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Belum Ada Donasi</h3>
                        <a href="/" class="inline-block px-6 py-3 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded-xl transition-colors">
                            <i class="fa-solid fa-hand-holding-heart mr-2"></i> Mulai Donasi
                        </a>
                    </div>
                    @endforelse
                </div>

                {{-- pagination --}}
                @if($donations->hasPages())
                <div class="mt-8">
                    {{ $donations->links() }}
                </div>
                @endif
            </div>

@endsection
