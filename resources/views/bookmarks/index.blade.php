@extends('layouts.app')
@section('title', 'Bookmark')
@section('content')


            <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        <i class="fas fa-bookmark text-cyan-600 dark:text-cyan-400 mr-2"></i>
                        Bookmark Saya
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $bookmarks->total() }} postingan tersimpan
                    </p>
                </div>

                <!-- Success Message -->
                @if (session('success'))
                    <div class="mb-6 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-green-700 dark:text-green-400 hover:text-green-900">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                <!-- Bookmarks List -->
                @if($bookmarks->count() > 0)
                    <div class="space-y-4">
                        @foreach($bookmarks as $bookmark)
                            @if($bookmark->post)
                                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow">
                                    <div class="p-4">
                                        <!-- Header -->
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex items-center space-x-3 flex-1">

                                                <img src="{{ $bookmark->post->user->avatar_url }}"
                                                    alt="{{ $bookmark->post->user->name }}"
                                                    class="w-10 h-10 rounded-full">

                                                <div class="flex-1 min-w-0">

                                                    <h3 class="font-semibold text-sm text-gray-900 dark:text-white truncate">
                                                        {{ $bookmark->post->user->name }}
                                                    </h3>

                                                    <div class="flex items-center space-x-2 text-xs text-gray-500 dark:text-gray-400">

                                                        <span>{{ $bookmark->post->created_at->diffForHumans() }}</span>
                                                        @if ($bookmark->post->category)
                                                            <span>•</span>
                                                            <span class="text-cyan-600 dark:text-cyan-400">
                                                                {{ $bookmark->post->category->name }}
                                                            </span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>


                                            <form action="{{ route('bookmarks.destroy', $bookmark) }}" method="POST" onsubmit="return confirm('Hapus bookmark ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Image -->
                                        @if($bookmark->post->image)
                                            <a href="{{ route('posts.show', $bookmark->post) }}" class="block mb-3">
                                                <img src="{{ $bookmark->post->image_url }}"
                                                     class="w-full h-64 object-cover rounded-lg">
                                            </a>
                                        @endif

                                        <!-- Content -->
                                        <a href="{{ route('posts.show', $bookmark->post) }}" class="block mb-3">
                                            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-1 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
                                                {{ $bookmark->post->title }}
                                            </h2>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                                {{ $bookmark->post->description }}
                                            </p>
                                        </a>

                

                                        <!-- Actions -->
                                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                            <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                                                <span>
                                                    <i class="far fa-heart mr-1"></i>
                                                    {{ $bookmark->post->likes()->count() }}
                                                </span>
                                                <span>
                                                    <i class="far fa-comment mr-1"></i>
                                                    {{ $bookmark->post->comments()->count() }}
                                                </span>
                                            </div>
                                            <a href="{{ route('posts.show', $bookmark->post) }}"
                                               class="text-sm font-medium text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300">
                                                Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($bookmarks->hasPages())
                        <div class="mt-6">
                            {{ $bookmarks->links() }}
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-16 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                            <i class="fas fa-bookmark text-4xl text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                            Belum Ada Bookmark
                        </h3>


                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

@endsection
