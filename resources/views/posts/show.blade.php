@extends('layouts.app')

@section('title', $post->title)
@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        @include('partials.navbar')

        <div class="container mx-auto px-4 max-w-7xl mt-6">

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div
                    class="mb-6 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg flex items-center justify-between animate-fade-in">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                    <button onclick="this.parentElement.remove()"
                        class="text-green-700 dark:text-green-400 hover:text-green-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <div class="flex gap-6">

                <!-- Sidebar Kiri (Hidden on mobile) -->
                <aside class="hidden lg:block w-64 shrink-0">
                    @include('partials.sidebar-left')
                </aside>

                <!-- Main Content -->
                <main class="flex-1 min-w-0 space-y-6">

                    <!-- Post Card -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

                        <!-- Post Header -->
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $post->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&background=06b6d4&color=fff' }}"
                                        alt="{{ $post->user->name }}" class="w-12 h-12 rounded-full ring-2 ring-cyan-500">
                                    <div>
                                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $post->user->name }}</h3>
                                        <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                                            <i class="far fa-clock"></i>
                                            <span>{{ $post->created_at->diffForHumans() }}</span>
                                            @if ($post->category)
                                                <span>•</span>
                                                <span class="text-cyan-600 dark:text-cyan-400">
                                                    <i class="fas fa-tag"></i> {{ $post->category->name }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if ($isOwner)
                                    <a href="{{ route('posts.edit', $post) }}"
                                        class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Title -->
                        <div class="px-6 py-4">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $post->title }}</h1>
                        </div>

                        <!-- Images Gallery -->
                        @if ($post->images && count($post->images) > 0)
                            <div class="relative">
                                @if (count($post->images) == 1)
                                    <img src="{{ asset('storage/' . $post->images[0]) }}" alt="{{ $post->title }}"
                                        class="w-full h-96 object-cover">
                                @else
                                    <div class="relative" x-data="{ currentSlide: 0, totalSlides: {{ count($post->images) }} }">
                                        <div class="overflow-hidden">
                                            @foreach ($post->images as $index => $image)
                                                <div x-show="currentSlide === {{ $index }}" x-transition
                                                    class="w-full">
                                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $post->title }}"
                                                        class="w-full h-96 object-cover">
                                                </div>
                                            @endforeach
                                        </div>

                                        <button
                                            @click="currentSlide = currentSlide > 0 ? currentSlide - 1 : totalSlides - 1"
                                            class="absolute left-4 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-75 transition-all">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button
                                            @click="currentSlide = currentSlide < totalSlides - 1 ? currentSlide + 1 : 0"
                                            class="absolute right-4 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-75 transition-all">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>

                                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
                                            @foreach ($post->images as $index => $image)
                                                <button @click="currentSlide = {{ $index }}"
                                                    :class="currentSlide === {{ $index }} ? 'bg-white w-6' :
                                                        'bg-white bg-opacity-50 w-2'"
                                                    class="h-2 rounded-full transition-all"></button>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Description -->
                        <div class="px-6 py-6 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                <i class="fas fa-info-circle text-cyan-500 mr-2"></i>Detail Kampanye
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

                    <!-- Comments Section -->
                    <div id="comments"
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                                <i class="fas fa-comments text-blue-500 mr-2"></i>
                                Komentar <span
                                    class="ml-2 text-sm font-normal text-gray-500">({{ $post->comments_count }})</span>
                            </h3>
                        </div>

                        <!-- Comment Form -->
                        @auth
                            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                                <form action="{{ route('comments.store', $post) }}" method="POST" class="flex space-x-3">
                                    @csrf
                                    <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=06b6d4&color=fff' }}"
                                        alt="{{ Auth::user()->name }}"
                                        class="w-10 h-10 rounded-full ring-2 ring-gray-200 dark:ring-gray-600">
                                    <div class="flex-1">
                                        <textarea name="content" rows="3" placeholder="Tulis komentar Anda..."
                                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white resize-none"
                                            required></textarea>
                                        <div class="flex justify-end mt-2">
                                            <button type="submit"
                                                class="px-6 py-2 bg-cyan-500 hover:bg-cyan-600 text-white font-medium rounded-lg transition-colors">
                                                <i class="fas fa-paper-plane mr-2"></i>Kirim
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
                                        <img src="{{ $comment->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&background=06b6d4&color=fff' }}"
                                            alt="{{ $comment->user->name }}"
                                            class="w-10 h-10 rounded-full ring-2 ring-gray-200 dark:ring-gray-600 shrink-0">

                                        <div class="flex-1 min-w-0">
                                            <!-- Comment Header -->
                                            <div class="flex items-center mb-1">
                                                <span class="font-semibold text-gray-900 dark:text-white">
                                                    {{ $comment->user->name }}
                                                </span>
                                                <span class="mx-2 text-gray-400">•</span>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $comment->created_at->diffForHumans() }}
                                                </span>
                                            </div>

                                            <!-- Comment Content -->
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
                                        Jadilah yang pertama berkomentar!
                                    </p>
                                </div>
                            @endforelse
                        </div>

                    </div>

                </main>

                <!-- Sidebar Kanan -->
                <aside class="hidden xl:block w-80 shrink-0">

                    <!-- Donation Card -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 sticky top-24 space-y-6">

                        <!-- Progress Section -->
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Dana Terkumpul</p>
                            <p class="text-3xl font-bold text-cyan-600 dark:text-cyan-400 mb-1">
                                Rp {{ number_format($post->current_amount, 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                dari target Rp {{ number_format($post->target_amount, 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Progress Bar -->
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                            @php
                                $percentage =
                                    $post->target_amount > 0
                                        ? min(($post->current_amount / $post->target_amount) * 100, 100)
                                        : 0;
                            @endphp
                            <div class="bg-lienar-to-r from-cyan-500 to-cyan-600 h-3 rounded-full transition-all duration-500"
                                style="width: {{ $percentage }}%"></div>
                        </div>

                        <!-- Stats Grid -->
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg text-center">
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $post->donors_count }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    <i class="fas fa-users mr-1"></i>Donatur
                                </p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg text-center">
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ number_format($percentage, 0) }}%</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    <i class="fas fa-chart-line mr-1"></i>Tercapai
                                </p>
                            </div>
                        </div>

                        <!-- Donate Button -->
                        <a href="{{ route('donations.create', $post) }}"
                            class="block w-full px-6 py-3 bg-lienar-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 text-center">
                            <i class="fas fa-hand-holding-heart mr-2"></i>Donasi Sekarang
                        </a>

                        <!-- Top Donors -->
                        <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                                Top Donatur
                            </h4>

                            @if ($topDonors->count() > 0)
                                <div class="space-y-3">
                                    @foreach ($topDonors->take(5) as $index => $donor)
                                        <div class="flex items-center space-x-3">
                                            <span
                                                class="flex items-center justify-center w-8 h-8 rounded-full text-sm font-bold text-white shrink-0 {{ $index === 0 ? 'bg-yellow-500' : ($index === 1 ? 'bg-gray-400' : ($index === 2 ? 'bg-orange-600' : 'bg-cyan-500')) }}">
                                                {{ $index + 1 }}
                                            </span>
                                            <img src="{{ $donor->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($donor->user->name) . '&background=06b6d4&color=fff' }}"
                                                alt="{{ $donor->user->name }}" class="w-8 h-8 rounded-full">
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                    {{ $donor->user->name }}</p>
                                                <p class="text-xs text-cyan-600 dark:text-cyan-400 font-semibold">
                                                    Rp {{ number_format($donor->total_donated / 1000, 0) }}K
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if ($topDonors->count() > 5)
                                    <button
                                        class="w-full mt-3 py-2 text-sm text-cyan-600 dark:text-cyan-400 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors font-medium">
                                        Lihat Semua ({{ $topDonors->count() }})
                                    </button>
                                @endif
                            @else
                                <div class="text-center py-6 text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-users text-3xl mb-2"></i>
                                    <p class="text-sm">Belum ada donatur</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </aside>
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

        function toggleReply(id) {
            const form = document.getElementById('reply-form-' + id);
            form.classList.toggle('hidden');
        }
    </script>
@endsection
