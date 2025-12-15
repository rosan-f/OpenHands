@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    @include('partials.navbar')

    <div class="container mx-auto px-4 max-w-7xl mt-6">

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-6 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg flex items-center justify-between animate-fade-in">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-700 dark:text-green-400 hover:text-green-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Post Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

                    <!-- Post Header -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $post->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&background=06b6d4&color=fff' }}"
                                     alt="{{ $post->user->name }}"
                                     class="w-12 h-12 rounded-full ring-2 ring-cyan-500">
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $post->user->name }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        <i class="far fa-clock mr-1"></i>{{ $post->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            @if($isOwner)
                            <div class="flex space-x-2">
                                <a href="{{ route('posts.edit', $post) }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                            </div>
                            @endif
                        </div>

                        <!-- Category Badge -->
                        <span class="inline-block px-3 py-1 bg-cyan-100 dark:bg-cyan-900 text-cyan-700 dark:text-cyan-300 text-sm font-medium rounded-full">
                            <i class="fas fa-tag mr-1"></i>{{ $post->category->name }}
                        </span>
                    </div>

                    <!-- Title -->
                    <div class="px-6 py-4">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">{{ $post->title }}</h1>
                    </div>

                    <!-- Images Gallery -->
                    @if($post->images && count($post->images) > 0)
                    <div class="relative">
                        @if(count($post->images) == 1)
                            <img src="{{ asset('storage/' . $post->images[0]) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover">
                        @else
                            <!-- Image Slider -->
                            <div class="relative" x-data="{ currentSlide: 0, totalSlides: {{ count($post->images) }} }">
                                <div class="overflow-hidden">
                                    @foreach($post->images as $index => $image)
                                    <div x-show="currentSlide === {{ $index }}" x-transition class="w-full">
                                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover">
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Navigation -->
                                <button @click="currentSlide = currentSlide > 0 ? currentSlide - 1 : totalSlides - 1"
                                        class="absolute left-4 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-75 transition-all">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button @click="currentSlide = currentSlide < totalSlides - 1 ? currentSlide + 1 : 0"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-75 transition-all">
                                    <i class="fas fa-chevron-right"></i>
                                </button>

                                <!-- Indicators -->
                                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
                                    @foreach($post->images as $index => $image)
                                    <button @click="currentSlide = {{ $index }}"
                                            :class="currentSlide === {{ $index }} ? 'bg-white' : 'bg-white bg-opacity-50'"
                                            class="w-2 h-2 rounded-full transition-all"></button>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    @endif

                    <!-- Description -->
                    <div class="px-6 py-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                            <i class="fas fa-info-circle text-cyan-500 mr-2"></i>Detail Kampanye
                        </h3>
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">{{ $post->description }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-750 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <!-- Like -->
                                <form action="{{ route('posts.like', $post->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="flex items-center space-x-1 text-gray-600 dark:text-gray-400 hover:text-red-500 transition-colors">
                                        <i class="fas fa-heart {{ $hasLiked ? 'text-red-500' : '' }}"></i>
                                        <span class="text-sm font-medium">{{ $post->likes_count }}</span>
                                    </button>
                                </form>

                                <!-- Comment -->
                                <a href="#comments" class="flex items-center space-x-1 text-gray-600 dark:text-gray-400 hover:text-blue-500 transition-colors">
                                    <i class="fas fa-comment"></i>
                                    <span class="text-sm font-medium">{{ $post->comments_count }}</span>
                                </a>

                                <!-- Share -->
                                <button onclick="sharePost()" class="flex items-center space-x-1 text-gray-600 dark:text-gray-400 hover:text-green-500 transition-colors">
                                    <i class="fas fa-share-alt"></i>
                                    <span class="text-sm font-medium">Bagikan</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top 10 Donors -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-trophy text-yellow-500 mr-2"></i>Top 10 Donatur Teratas
                    </h3>

                    @if($topDonors->count() > 0)
                    <div class="space-y-3">
                        @foreach($topDonors as $index => $donor)
                        <div class="flex items-center space-x-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                            <div class="shrink-0">
                                <span class="flex items-center justify-center w-10 h-10 rounded-full font-bold text-white {{ $index === 0 ? 'bg-yellow-500' : ($index === 1 ? 'bg-gray-400' : ($index === 2 ? 'bg-orange-600' : 'bg-cyan-500')) }}">
                                    {{ $index + 1 }}
                                </span>
                            </div>
                            <img src="{{ $donor->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($donor->user->name) . '&background=06b6d4&color=fff' }}"
                                 alt="{{ $donor->user->name }}"
                                 class="w-12 h-12 rounded-full">
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $donor->user->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-donate mr-1"></i>{{ $donor->donation_count }}x donasi
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-cyan-600 dark:text-cyan-400">
                                    Rp {{ number_format($donor->total_donated, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-users text-4xl mb-3"></i>
                        <p>Belum ada donatur</p>
                    </div>
                    @endif
                </div>

                <!-- Comments Section -->
                <div id="comments" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-comments text-blue-500 mr-2"></i>Komentar ({{ $post->comments_count }})
                    </h3>

                    <!-- Comment Form -->
                    @auth
                    <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-6">
                        @csrf
                        <div class="flex space-x-3">
                            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=06b6d4&color=fff' }}"
                                 alt="{{ Auth::user()->name }}"
                                 class="w-10 h-10 rounded-full">
                            <div class="flex-1">
                                <textarea name="content" rows="3" placeholder="Tulis komentar..."
                                          class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 text-gray-900 dark:text-white resize-none"
                                          required></textarea>
                                <button type="submit" class="mt-2 px-6 py-2 bg-cyan-500 hover:bg-cyan-600 text-white font-medium rounded-lg transition-colors">
                                    <i class="fas fa-paper-plane mr-2"></i>Kirim
                                </button>
                            </div>
                        </div>
                    </form>
                    @else
                    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-center">
                        <p class="text-gray-600 dark:text-gray-400">
                            <a href="{{ route('login') }}" class="text-cyan-600 dark:text-cyan-400 hover:underline font-medium">
                                <i class="fas fa-sign-in-alt mr-1"></i>Login
                            </a> untuk berkomentar
                        </p>
                    </div>
                    @endauth

                    <!-- Comments List -->
                    <div class="space-y-4">
                        @forelse($post->comments as $comment)
                        <div class="flex space-x-3">
                            <img src="{{ $comment->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&background=06b6d4&color=fff' }}"
                                 alt="{{ $comment->user->name }}"
                                 class="w-10 h-10 rounded-full shrink-0">
                            <div class="flex-1">
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $comment->user->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            <i class="far fa-clock mr-1"></i>{{ $comment->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <i class="far fa-comments text-4xl mb-3"></i>
                            <p>Belum ada komentar</p>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="space-y-6">

                <!-- Donation Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 sticky top-24">
                    <div class="mb-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Dana Terkumpul</p>
                        <p class="text-3xl font-bold text-cyan-600 dark:text-cyan-400">
                            Rp {{ number_format($post->current_amount, 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            dari target Rp {{ number_format($post->target_amount, 0, ',', '.') }}
                        </p>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 mb-4 overflow-hidden">
                        @php
                            $percentage = $post->target_amount > 0 ? min(($post->current_amount / $post->target_amount) * 100, 100) : 0;
                        @endphp
                        <div class="bg-linear-to-r from-cyan-500 to-cyan-600 h-3 rounded-full transition-all duration-500"
                             style="width: {{ $percentage }}%"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6 text-center">
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $post->donors_count }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400"><i class="fas fa-users mr-1"></i>Donatur</p>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($percentage, 1) }}%</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400"><i class="fas fa-chart-line mr-1"></i>Tercapai</p>
                        </div>
                    </div>

                    <a href="{{ route('donations.create', $post) }}" class="block w-full px-6 py-3 bg-linear-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 text-center">
                        <i class="fas fa-hand-holding-heart mr-2"></i>Donasi Sekarang
                    </a>
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
