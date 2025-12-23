@extends('layouts.app')

@section('title', $post->title)
@section('content')


    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Message -->
        @if (session('success'))
            <div
                class="mb-6 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg flex items-center justify-between animate-fade-in">
                <div class="flex items-center">
                    {{ session('success') }}
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-700 dark:text-green-400 hover:text-green-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <div class="flex gap-6">
            <div class="flex-1 min-w-0 space-y-6">
                <!-- Post Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- Post Header -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-3">

                                <img src="{{ $post->user->avatar_url }}" class="w-12 h-12 rounded-full border-2 border-gray-200 dark:border-gray-700">



                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">
                                        {{ $post->user->name }}</h3>
                                    <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                                        <i class="far fa-clock"></i>
                                        <span>{{ $post->created_at->diffForHumans() }}</span>
                                        @if ($post->category)
                                            <span>•</span>
                                            <span class="text-cyan-600 dark:text-cyan-400">
                                                {{ $post->category->name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if ($isOwner)
                                <button type="button" id="delete-post-btn"
                                    class="px-4 py-2 bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400 font-medium rounded-lg hover:bg-red-200 dark:hover:bg-red-900/30 transition-colors text-sm">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            @endif

                        </div>
                    </div>

                    <!-- Title -->
                    <div class="px-6 py-4">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $post->title }}</h1>
                    </div>

                    <!-- Image -->
                    @if ($post->image)
                        <div class="relative">
                            <img src="{{ $post->image_url}} " alt="{{ $post->title }}"
                                class="w-full h-96 object-cover">
                        </div>
                    @endif

                    <!-- Description -->
                    <div class="px-6 py-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                            Detail Kampanye
                        </h3>
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                                {{ $post->description }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-750 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-6">
                                <!-- Like -->
                                <form action="{{ route('posts.like', $post->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center space-x-2 text-gray-600 dark:text-gray-400 hover:text-red-500 transition-colors group">
                                        <i
                                            class="fas fa-heart text-lg {{ $hasLiked ? 'text-red-500' : '' }} group-hover:scale-110 transition-transform"></i>
                                        <span class="text-sm font-semibold">{{ $post->likes_count }}</span>
                                    </button>
                                </form>

                                <!-- Comment -->
                                <a href="#comments"
                                    class="flex items-center space-x-2 text-gray-600 dark:text-gray-400 hover:text-blue-500 transition-colors group">
                                    <i class="fas fa-comment text-lg group-hover:scale-110 transition-transform"></i>
                                    <span class="text-sm font-semibold">{{ $post->comments_count }}</span>
                                </a>

                                <!-- Share -->
                                <button onclick="sharePost()"
                                    class="flex items-center space-x-2 text-gray-600 dark:text-gray-400 hover:text-green-500 transition-colors group">
                                    <i class="fas fa-share-alt text-lg group-hover:scale-110 transition-transform"></i>
                                    <span class="text-sm font-semibold">Bagikan</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Donation Box -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="text-center mb-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Dana Terkumpul</p>
                        <p class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">
                            Rp {{ number_format($post->collected_amount, 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            dari target Rp {{ number_format($post->target_amount, 0, ',', '.') }}
                        </p>
                    </div>

                    <!-- Progress Bar -->
                    @php
                        $percentage =
                            $post->target_amount > 0
                                ? min(($post->collected_amount / $post->target_amount) * 100, 100)
                                : 0;
                    @endphp

                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mb-4">
                        <div class="bg-linear-to-r from-cyan-500 to-cyan-600 h-2.5 rounded-full transition-all duration-500"
                            style="width: {{ $percentage }}%"></div>
                    </div>

                    <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-5">
                        <span>{{ number_format($percentage, 1) }}% tercapai</span>
                        <span>{{ $post->donors_count }} donatur</span>
                    </div>

                    <a href="{{ route('donations.create', $post) }}"
                        class="w-full px-6 py-3 bg-linear-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 text-center block">
                        Donasi Sekarang
                    </a>
                </div>

                <!-- Comments -->
                <div id="comments"
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                            Komentar <span
                                class="ml-2 text-sm font-normal text-gray-500">({{ $post->comments_count }})</span>
                        </h3>
                    </div>

                    <!-- Comment Form -->
                    @auth
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <form action="{{ route('comments.store', $post) }}" method="POST" class="flex space-x-3">
                                @csrf

                                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) :
                                 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=06b6d4&color=fff' }}"

                                    alt="{{ Auth::user()->name }}"
                                    class="w-10 h-10 rounded-full ring-2 ring-gray-200 dark:ring-gray-600">

                                <div class="flex-1">
                                    <textarea name="content" rows="3" placeholder="Tulis komentar Anda..."
                                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white resize-none"
                                        required></textarea>
                                    <div class="flex justify-end mt-2">
                                        <button type="submit"
                                            class="px-6 py-2 bg-cyan-500 hover:bg-cyan-600 text-white font-medium rounded-lg transition-colors">
                                            <i class="fas fa-paper-plane mr-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 text-center">
                                <i class="fas fa-lock text-3xl text-gray-400 mb-3"></i>
                                <p class="text-gray-600 dark:text-gray-400 mb-3">Silakan login untuk berkomentar</p>
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center px-6 py-2 bg-cyan-500 hover:bg-cyan-600 text-white font-medium rounded-lg transition-colors">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                                </a>
                            </div>
                        </div>
                    @endauth

                    <!-- Comments List -->
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($post->comments as $comment)
                            <div class="p-6">
                                <div class="flex space-x-3">

                                    <img src="{{$comment->user->avatar_url }}"
                                        alt="{{ $comment->user->name }}"
                                        class="w-10 h-10 rounded-full ring-2 ring-gray-200 dark:ring-gray-600 shrink-0">

                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center mb-1">
                                            <span class="font-semibold text-gray-900 dark:text-white">
                                                {{ $comment->user->name }}
                                            </span>
                                            <span class="mx-2 text-gray-400">•</span>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $comment->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                            {{ $comment->content }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <i class="far fa-comments text-5xl text-gray-300 dark:text-gray-600 mb-3"></i>
                                <p class="text-gray-500 dark:text-gray-400">Belum ada komentar</p>
                                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">
                                    Jadilah yang pertama berkomentar
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function sharePost() {
            const url = window.location.href;

            if (navigator.share) {
                navigator.share({
                    title: '{{ $post->title }}',
                    text: 'Mari bantu kampanye ini!',
                    url: url
                }).catch(() => {});
            } else {
                navigator.clipboard.writeText(url).then(() => {
                    alert('Link berhasil disalin!');
                });
            }
        }
    </script>
@endsection
