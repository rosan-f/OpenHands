@extends('layouts.app')

@section('title', 'beranda')
@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
    <!-- Header/Navbar -->
    @include('partials.navbar')

    <div class="container mx-auto px-4 py-6 max-w-7xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Sidebar Kiri (Hidden on mobile) -->
            <aside class="hidden lg:block lg:col-span-3">
                @include('partials.sidebar-left')
            </aside>

            <!-- Main Content -->
            <main class="lg:col-span-6">
                <!-- Posts Feed -->
                <div class="space-y-4">
                    @forelse($posts ?? [] as $post)
                        @include('partials.post-card', ['post' => $post])
                    @empty
                        @include('partials.empty-state')
                    @endforelse
                </div>

                <!-- Load More / Pagination -->
                @if(isset($posts) && $posts->hasMorePages())
                <div class="mt-6 text-center">
                    <a href="{{ $posts->nextPageUrl() }}" class="px-6 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors inline-block">
                        Muat Lebih Banyak
                    </a>
                </div>
                @endif
            </main>

            <!-- Sidebar Kanan (Hidden on mobile) -->
            <aside class="hidden lg:block lg:col-span-3">
                @include('partials.sidebar-right')
            </aside>

        </div>
    </div>
</div>
@endsection
