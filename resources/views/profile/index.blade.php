@extends('layouts.app')
@section('title', $user->name)
@section('content')


    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Profile Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:space-x-8">
                <!-- Avatar -->
                <div class="flex justify-center md:justify-start mb-6 md:mb-0">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                        class="w-32 h-32 md:w-40 md:h-40 rounded-full ring-4 ring-gray-200 dark:ring-gray-700">
                </div>

                <!-- Profile Info -->
                <div class="flex-1">
                    <div class="flex flex-col md:flex-row md:items-center md:space-x-4 mb-4">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2 md:mb-0">
                            {{ $user->name }}
                        </h1>

                        @if ($isOwnProfile)
                            <div class="flex space-x-2">
                                <a href="{{ route('profile.edit') }}"
                                    class="px-4 py-1.5 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white text-sm font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                    Edit Profil
                                </a>

                            </div>
                        @endif
                    </div>



                    <!-- Bio -->
                    @if ($user->bio)
                        <div class="mb-3">
                            <p class="text-sm text-gray-900 dark:text-white">{{ $user->bio }}</p>
                        </div>
                    @endif

                    <!-- Location -->
                    @if ($user->location)
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i class="fa-solid fa-location-dot mr-2"></i>
                            <span>{{ $user->location }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div
                class="bg-linear-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 rounded-xl p-4 text-center">
                <div class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">{{ $stats['active_campaigns'] }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Aktif</div>
            </div>
            <div
                class="bg-linear-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 rounded-xl p-4 text-center">
                <div class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">{{ $stats['donations_made'] }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Donasi</div>
            </div>
            <div
                class="bg-linear-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 rounded-xl p-4 text-center">
                <div class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">
                    Rp {{ number_format($stats['total_donated'], 0, ',', '.') }}
                </div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Dibagikan</div>
            </div>
            <div
                class="bg-linear-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 rounded-xl p-4 text-center">
                <div class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">
                    Rp {{ number_format($stats['total_received'], 0, ',', '.') }}

                </div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Diterima</div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="border-b border-gray-200 dark:border-gray-800 mb-6">
            <div class="flex justify-center space-x-8">
                <button
                    class="pb-3 border-b-2 border-gray-900 dark:border-white text-gray-900 dark:text-white font-semibold">
                    <i class="fa-solid fa-grid-2 mr-2"></i> Kampanye
                </button>
            </div>
        </div>

        <!-- Posts Grid -->
        <div class="grid grid-cols-3 gap-1 md:gap-4">
            @forelse($posts as $post)
                <a href="{{ route('posts.show', $post->id) }}"
                    class="group relative aspect-square overflow-hidden rounded-lg">
                    @if ($post->images && count($post->images) > 0)
                        <img src="{{ asset('storage/' . $post->images[0]) }}" alt="{{ $post->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    @else
                        <div
                            class="w-full h-full bg-linear-to-br from-cyan-100 to-cyan-200 dark:from-cyan-900/20 dark:to-cyan-800/20 flex items-center justify-center">
                            <i class="fa-solid fa-image text-4xl text-gray-400"></i>
                        </div>
                    @endif

                    <!-- Overlay -->
                    <div
                        class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <div class="text-white flex space-x-4">
                            <span class="flex items-center">
                                <i class="fa-solid fa-heart mr-2"></i> {{ $post->likes_count }}
                            </span>
                            <span class="flex items-center">
                                <i class="fa-solid fa-comment mr-2"></i> {{ $post->comments_count }}
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-3 text-center py-12">
                    <i class="fa-solid fa-inbox text-4xl text-gray-300 dark:text-gray-700 mb-3"></i>
                    <p class="text-gray-500 dark:text-gray-400">Belum ada kampanye</p>
                </div>
            @endforelse
        </div>


        @if ($posts->hasPages())
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        @endif
    </div>


@endsection
