@extends('layouts.app')
@section('title', 'Beranda')
@section('content')
<div class="min-h-screen bg-white dark:bg-gray-900 transition-colors duration-200">
    <div class="flex">
        <!-- Sidebar Kiri - Desktop Only -->
        <aside class="hidden lg:flex flex-col fixed left-0 top-0 h-screen w-64 border-r border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 z-40">
            @include('partials.sidebar-left')
        </aside>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-64 pb-16 lg:pb-0">
            <div class="max-w-2xl mx-auto">
                <!-- Posts Feed -->
                <div class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($posts ?? [] as $post)
                        @include('partials.post-card', ['post' => $post])
                    @empty
                        @include('partials.empty-state')
                    @endforelse
                </div>

                <!-- Load More / Pagination -->
                @if(isset($posts) && $posts->hasMorePages())
                <div class="py-8 text-center border-t border-gray-200 dark:border-gray-800">
                    <a href="{{ $posts->nextPageUrl() }}"
                       class="inline-flex items-center px-6 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                        Muat Lebih Banyak
                    </a>
                </div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection
