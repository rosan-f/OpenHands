@extends('layouts.app')
@section('title', 'Tersimpan')
@section('content')

<div class="min-h-screen bg-white dark:bg-gray-900 pt-14 lg:pt-0 pb-16 lg:pb-0">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="hidden lg:flex flex-col fixed left-0 top-0 h-screen w-64 border-r border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 z-40">
            @include('partials.sidebar-left')
        </aside>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-64">
            <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Postingan Tersimpan</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $savedPosts->total() }} postingan tersimpan
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

                <!-- Saved Posts Grid -->
                @if($savedPosts->count() > 0)
                    <div class="space-y-0 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-800 divide-y divide-gray-200 dark:divide-gray-800">
                        @foreach($savedPosts as $savedPost)
                            @if($savedPost->post)
                                <div class="relative group">
                                    <!-- Delete Button (Top Right) -->
                                    <button onclick="deleteSavedPost({{ $savedPost->id }})"
                                        class="absolute top-4 right-4 z-10 w-8 h-8 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 rounded-full shadow-md hover:shadow-lg transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <i class="fas fa-times text-sm"></i>
                                    </button>

                                    <!-- Post Card -->
                                    <div class="overflow-hidden hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors py-6">
                                        <!-- Post Header -->
                                        <div class="px-4 py-4 pb-2 flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <img src="{{ $savedPost->post->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($savedPost->post->user->name ?? 'User') . '&background=06b6d4&color=fff' }}"
                                                    alt="{{ $savedPost->post->user->name ?? 'User' }}" class="w-10 h-10 rounded-full">
                                                <div>
                                                    <h3 class="font-semibold text-sm text-gray-900 dark:text-white">
                                                        {{ $savedPost->post->user->name ?? 'Anonymous' }}
                                                    </h3>
                                                    <div class="flex items-center space-x-2 text-xs text-gray-500 dark:text-gray-400">
                                                        <span>{{ $savedPost->post->created_at->diffForHumans() }}</span>
                                                        @if ($savedPost->post->category)
                                                            <span>•</span>
                                                            <span class="text-cyan-600 dark:text-cyan-400">
                                                                {{ $savedPost->post->category->name }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Post Image -->
                                        @if ($savedPost->post->image)
                                            <div class="px-4 mb-3">
                                                <a href="{{ route('posts.show', $savedPost->post->id) }}" class="block">
                                                    <img src="{{ asset('storage/' . $savedPost->post->image) }}"
                                                         alt="{{ $savedPost->post->title }}"
                                                         class="w-full max-h-96 object-cover rounded-lg">
                                                </a>
                                            </div>
                                        @endif

                                        <!-- Action Buttons -->
                                        <div class="px-4 mb-3">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-4">
                                                    <!-- Like Button -->
                                                    <form action="{{ route('posts.like', $savedPost->post->id) }}" method="POST" class="like-form">
                                                        @csrf
                                                        <button type="submit"
                                                            class="flex items-center space-x-2 text-gray-900 dark:text-white hover:text-gray-600 dark:hover:text-gray-400 transition-colors">
                                                            <i class="fa-{{ $savedPost->post->isLikedByUser ?? false ? 'solid' : 'regular' }} fa-heart text-2xl {{ $savedPost->post->isLikedByUser ?? false ? 'text-red-500' : '' }}"></i>
                                                        </button>
                                                    </form>

                                                    <!-- Comment Button -->
                                                    <a href="{{ route('posts.show', $savedPost->post->id) }}#comments"
                                                        class="text-gray-900 dark:text-white hover:text-gray-600 dark:hover:text-gray-400 transition-colors">
                                                        <i class="fa-regular fa-comment text-2xl"></i>
                                                    </a>

                                                    <!-- Share Button -->
                                                    <button onclick="sharePost({{ $savedPost->post->id }})"
                                                        class="text-gray-900 dark:text-white hover:text-gray-600 dark:hover:text-gray-400 transition-colors">
                                                        <i class="fa-regular fa-paper-plane text-2xl"></i>
                                                    </button>
                                                </div>

                                                <!-- Bookmark (Always filled in saved posts) -->
                                                <button onclick="toggleSavePost({{ $savedPost->post->id }}, this)" data-saved="true"
                                                    class="text-gray-900 dark:text-white hover:text-gray-600 dark:hover:text-gray-400 transition-colors">
                                                    <i class="fa-solid fa-bookmark text-2xl text-cyan-600 dark:text-cyan-400"></i>
                                                </button>
                                            </div>

                                            <!-- Likes Count -->
                                            <div class="mt-2">
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                                    {{ $savedPost->post->likes_count ?? 0 }} suka
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Post Content -->
                                        <a href="{{ route('posts.show', $savedPost->post->id) }}" class="block px-4 pb-2">
                                            <div class="space-y-1">
                                                <h2 class="text-base font-semibold text-gray-900 dark:text-white hover:text-gray-600 dark:hover:text-gray-400 transition-colors">
                                                    {{ $savedPost->post->title }}
                                                </h2>
                                                <p class="text-sm text-gray-900 dark:text-white leading-relaxed">
                                                    <span class="font-semibold">{{ $savedPost->post->user->name ?? 'Anonymous' }}</span>
                                                    {{ Str::limit($savedPost->post->description, 150) }}
                                                    @if (strlen($savedPost->post->description) > 150)
                                                        <span class="text-gray-500 dark:text-gray-400"> selengkapnya</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </a>

                                        <!-- Comments Preview -->
                                        @if (($savedPost->post->comments_count ?? 0) > 0)
                                            <div class="px-4 pb-2">
                                                <a href="{{ route('posts.show', $savedPost->post->id) }}#comments"
                                                   class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                                    Lihat semua {{ $savedPost->post->comments_count }} komentar
                                                </a>
                                            </div>
                                        @endif

                                        <!-- Donation Progress -->
                                        <div class="px-4 pt-3 pb-4 border-t border-gray-200 dark:border-gray-800">
                                            <a href="{{ route('posts.show', $savedPost->post->id) }}" class="block">
                                                <div class="flex items-center justify-between mb-3">
                                                    <div>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Terkumpul</p>
                                                        <p class="text-lg font-bold text-cyan-600 dark:text-cyan-400">
                                                            Rp {{ number_format($savedPost->post->collected_amount ?? 0, 0, ',', '.') }}
                                                        </p>
                                                    </div>
                                                    <div class="text-right">
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Target</p>
                                                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                            Rp {{ number_format($savedPost->post->target_amount ?? 0, 0, ',', '.') }}
                                                        </p>
                                                    </div>
                                                </div>

                                                @php
                                                    $percentage = $savedPost->post->target_amount > 0
                                                        ? min(($savedPost->post->collected_amount / $savedPost->post->target_amount) * 100, 100)
                                                        : 0;
                                                @endphp

                                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 overflow-hidden mb-2">
                                                    <div class="bg-cyan-500 h-1.5 rounded-full transition-all duration-500"
                                                        style="width: {{ $percentage }}%"></div>
                                                </div>

                                                <div class="flex items-center justify-between text-xs text-gray-600 dark:text-gray-400">
                                                    <span>{{ number_format($percentage, 1) }}% tercapai</span>
                                                    <span>{{ $savedPost->post->donors_count ?? 0 }} donatur</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Hidden Delete Form -->
                                    <form id="delete-form-{{ $savedPost->id }}"
                                          action="{{ route('saved-posts.destroy', $savedPost) }}"
                                          method="POST"
                                          class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($savedPosts->hasPages())
                        <div class="mt-6">
                            {{ $savedPosts->links() }}
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
                        <i class="fas fa-bookmark text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                            Belum Ada Postingan Tersimpan
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Simpan postingan yang menarik untuk dibaca nanti
                        </p>
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all">
                            <i class="fas fa-home mr-2"></i>
                            Jelajahi Postingan
                        </a>
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

<script>
// Delete saved post
function deleteSavedPost(savedPostId) {
    if (confirm('Hapus postingan ini dari tersimpan?')) {
        document.getElementById('delete-form-' + savedPostId).submit();
    }
}

// Share post
function sharePost(postId) {
    const url = '{{ url('/posts') }}/' + postId;
    if (navigator.share) {
        navigator.share({
            title: 'OpenHands Campaign',
            url: url
        }).catch(() => {});
    } else {
        navigator.clipboard.writeText(url).then(() => {
            alert('Link berhasil disalin!');
        });
    }
}

// Toggle save post
function toggleSavePost(postId, button) {
    fetch(`/posts/${postId}/save`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        const icon = button.querySelector('i');
        if (data.saved) {
            icon.classList.remove('fa-regular');
            icon.classList.add('fa-solid', 'text-cyan-600', 'dark:text-cyan-400');
            button.dataset.saved = 'true';
        } else {
            icon.classList.remove('fa-solid', 'text-cyan-600', 'dark:text-cyan-400');
            icon.classList.add('fa-regular');
            button.dataset.saved = 'false';
            // Reload page to update list
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>

@endsection
