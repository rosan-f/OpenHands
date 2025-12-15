<div class=" overflow-hidden transition-all hover:shadow-md">

    <!-- Post Header -->
    <div class="p-4 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <img src="{{ $post->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name ?? 'User') . '&background=06b6d4&color=fff' }}"
                 alt="{{ $post->user->name ?? 'User' }}"
                 class="w-10 h-10 rounded-full">
            <div>
                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $post->user->name ?? 'Anonymous' }}</h3>
                <div class="flex items-center space-x-2 text-xs text-gray-500 dark:text-gray-400">
                    <span>{{ $post->created_at->diffForHumans() }}</span>
                    @if($post->category)
                    <span>•</span>
                    <span class="text-cyan-600 dark:text-cyan-400">{{ $post->category->name }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Post  -->
    <a href="{{ route('posts.show', $post->id) }}" class="block">
        <div class="px-4 pb-3">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
                {{ $post->title }}
            </h2>
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed line-clamp-3">
                {{ $post->description }}
            </p>
        </div>

        <!-- Post Images Gallery -->
        @if($post->images && count($post->images) > 0)
        <div class="relative">
            @if(count($post->images) == 1)
                <!-- Single Image -->
                <img src="{{ asset('storage/' . $post->images[0]) }}"
                     alt="{{ $post->title }}"
                     class="w-full h-96 object-cover">
            @elseif(count($post->images) == 2)
                <!-- Two Images Grid -->
                <div class="grid grid-cols-2 gap-1">
                    @foreach($post->images as $image)
                    <img src="{{ asset('storage/' . $image) }}"
                         alt="{{ $post->title }}"
                         class="w-full h-64 object-cover">
                    @endforeach
                </div>
            @elseif(count($post->images) == 3)
                <!-- Three Images Grid -->
                <div class="grid grid-cols-2 gap-1">
                    <img src="{{ asset('storage/' . $post->images[0]) }}"
                         alt="{{ $post->title }}"
                         class="w-full h-full row-span-2 object-cover">
                    <img src="{{ asset('storage/' . $post->images[1]) }}"
                         alt="{{ $post->title }}"
                         class="w-full h-32 object-cover">
                    <img src="{{ asset('storage/' . $post->images[2]) }}"
                         alt="{{ $post->title }}"
                         class="w-full h-32 object-cover">
                </div>
            @else
                <!-- Four or More Images Grid -->
                <div class="grid grid-cols-2 gap-1">
                    @foreach($post->images as $index => $image)
                        @if($index < 3)
                        <img src="{{ asset('storage/' . $image) }}"
                             alt="{{ $post->title }}"
                             class="w-full h-48 object-cover">
                        @elseif($index == 3)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $image) }}"
                                 alt="{{ $post->title }}"
                                 class="w-full h-48 object-cover">
                            @if(count($post->images) > 4)
                            <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
                                <span class="text-white text-2xl font-bold">+{{ count($post->images) - 4 }}</span>
                            </div>
                            @endif
                        </div>
                        @break
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
        @endif
    </a>

    <!-- Donation Progress -->
    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-750">
        <div class="flex items-center justify-between mb-2">
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Terkumpul</p>
                <p class="text-lg font-bold text-cyan-600 dark:text-cyan-400">
                    Rp {{ number_format($post->current_amount ?? 0, 0, ',', '.') }}
                </p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500 dark:text-gray-400">Target</p>
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                    Rp {{ number_format($post->target_amount ?? 0, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden">
            @php
                $percentage = $post->target_amount > 0 ? min(($post->current_amount / $post->target_amount) * 100, 100) : 0;
            @endphp
            <div class="bg-linear-to-r from-cyan-500 to-cyan-600 h-2 rounded-full transition-all duration-500"
                 style="width: {{ $percentage }}%"></div>
        </div>

        <div class="flex items-center justify-between mt-2 text-xs text-gray-600 dark:text-gray-400">
            <span>{{ number_format($percentage, 1) }}% tercapai</span>
            <span>{{ $post->donors_count ?? 0 }} donatur</span>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center space-x-4">
                <!-- Like Button -->
                <form action="{{ route('posts.like', $post->id) }}" method="POST" class="like-form">
                    @csrf
                    <button type="submit" class="flex items-center space-x-1 text-gray-600 dark:text-gray-400 hover:text-red-500 transition-colors group">
                        <i class="fas fa-heart {{ ($post->isLikedByUser ?? false) ? 'text-red-500' : '' }}"></i>
                        <span class="text-sm font-medium like-count">{{ $post->likes_count ?? 0 }}</span>
                    </button>
                </form>

                <!-- Comment Button -->
                <a href="{{ route('posts.show', $post->id) }}#comments" class="flex items-center space-x-1 text-gray-600 dark:text-gray-400 hover:text-blue-500 transition-colors">
                    <i class="fas fa-comment"></i>
                    <span class="text-sm font-medium">{{ $post->comments_count ?? 0 }}</span>
                </a>

                <!-- Share Button -->
                <button onclick="sharePost({{ $post->id }})" class="flex items-center space-x-1 text-gray-600 dark:text-gray-400 hover:text-green-500 transition-colors">
                    <i class="fas fa-share-alt"></i>
                    <span class="text-sm font-medium">Bagikan</span>
                </button>
            </div>
        </div>

        <!-- Donate Button -->
        <a href="{{ route('donations.create', $post->id) }}"
           class="block w-full text-center px-6 py-2.5 bg-linear-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
            <i class="fas fa-hand-holding-heart mr-2"></i>Donasi Sekarang
        </a>
    </div>
</div>

<script>
function sharePost(postId) {
    const url = '{{ url("/posts") }}/' + postId;

    if (navigator.share) {
        navigator.share({
            title: 'OpenHands Campaign',
            url: url
        }).catch(() => {});
    } else {
        // Fallback: Copy to clipboard
        navigator.clipboard.writeText(url).then(() => {
            alert('Link berhasil disalin!');
        });
    }
}
</script>
