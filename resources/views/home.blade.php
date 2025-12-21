@extends('layouts.app')
@section('title', 'Beranda')
@section('content')

    <div class="max-w-2xl mx-auto">
        <!-- Search Bar -->
        <div class="sticky top-14 lg:top-0 z-30 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 p-4">
            <form action="{{ route('search') }}" method="GET" class="relative">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="search" name="q" value="{{ request('q') }}"
                        placeholder="Cari..."
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-transparent transition-colors">
                </div>
            </form>
        </div>

        <!-- Posts Feed -->
        <div class="divide-y divide-gray-200 dark:divide-gray-800">
            @forelse($posts ?? [] as $post)
                @include('partials.post-card', ['post' => $post])
            @empty
                @include('partials.empty-state')
            @endforelse
        </div>

        <!-- Load More / Pagination -->
        @if (isset($posts) && $posts->hasMorePages())
            <div class="py-8 text-center border-t border-gray-200 dark:border-gray-800">
                <a href="{{ $posts->nextPageUrl() }}"
                    class="inline-flex items-center px-6 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                    Muat Lebih Banyak
                </a>
            </div>
        @endif
    </div>


@endsection
