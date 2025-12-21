<div class="overflow-hidden hover:shadow-md transition-shadow py-6">
    <!-- Post Header -->
    <div class="px-4 py-4 pb-2 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <img src="{{ $post->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name ?? 'User') . '&background=06b6d4&color=fff' }}"
                alt="{{ $post->user->name ?? 'User' }}" class="w-10 h-10 rounded-full">
            <div>
                <h3 class="font-semibold text-sm text-gray-900 dark:text-white">{{ $post->user->name ?? 'Anonymous' }}</h3>
                <div class="flex items-center space-x-2 text-xs text-gray-500 dark:text-gray-400">
                    <span>{{ $post->created_at->diffForHumans() }}</span>
                    @if ($post->category)
                        <span>•</span>
                        <span class="text-cyan-600 dark:text-cyan-400">{{ $post->category->name }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Post Image -->
    @if ($post->image)
        <div class="px-4 mb-3">
            <a href="{{ route('posts.show', $post->id) }}" class="block">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                    class="w-full max-h-96 object-cover rounded-lg">
            </a>
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="px-4 mb-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <!-- Like Button -->
                <form action="{{ route('posts.like', $post->id) }}" method="POST" class="like-form">
                    @csrf
                    <button type="submit"
                        class="flex items-center space-x-2 text-gray-900 dark:text-white hover:text-gray-600 dark:hover:text-gray-400 transition-colors">
                        <i class="fa-{{ $post->isLikedByUser ?? false ? 'solid' : 'regular' }} fa-heart text-2xl {{ $post->isLikedByUser ?? false ? 'text-red-500' : '' }}"></i>
                    </button>
                </form>

                <!-- Comment Button -->
                <a href="{{ route('posts.show', $post->id) }}#comments"
                    class="text-gray-900 dark:text-white hover:text-gray-600 dark:hover:text-gray-400 transition-colors">
                    <i class="fa-regular fa-comment text-2xl"></i>
                </a>

                <!-- Share Button -->
                <button onclick="sharePost({{ $post->id }})"
                    class="text-gray-900 dark:text-white hover:text-gray-600 dark:hover:text-gray-400 transition-colors">
                    <i class="fa-regular fa-paper-plane text-2xl"></i>
                </button>
            </div>

            <!-- Bookmark -->
            <button onclick="toggleSavePost({{ $post->id }}, this)"
                    data-saved="{{ $post->isSavedByUser ?? false ? 'true' : 'false' }}"
                    class="text-gray-900 dark:text-white hover:text-gray-600 dark:hover:text-gray-400 transition-colors">
                <i class="fa-{{ $post->isSavedByUser ?? false ? 'solid' : 'regular' }} fa-bookmark text-2xl {{ $post->isSavedByUser ?? false ? 'text-cyan-600 dark:text-cyan-400' : '' }}"></i>
            </button>
        </div>

        <!-- Likes Count -->
        <div class="mt-2">
            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                {{ $post->likes_count ?? 0 }} suka
            </p>
        </div>
    </div>

    <!-- Post Content -->
    <a href="{{ route('posts.show', $post->id) }}" class="block px-4 pb-2">
        <div class="space-y-1">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white hover:text-gray-600 dark:hover:text-gray-400 transition-colors">
                {{ $post->title }}
            </h2>
            <p class="text-sm text-gray-900 dark:text-white leading-relaxed">
                <span class="font-semibold">{{ $post->user->name ?? 'Anonymous' }}</span>
                {{ Str::limit($post->description, 150) }}
                @if (strlen($post->description) > 150)
                    <span class="text-gray-500 dark:text-gray-400"> selengkapnya</span>
                @endif
            </p>
        </div>
    </a>

    <!-- Comments Preview -->
    @if (($post->comments_count ?? 0) > 0)
        <div class="px-4 pb-2">
            <a href="{{ route('posts.show', $post->id) }}#comments" class="text-sm text-gray-500 dark:text-gray-400">
                Lihat semua {{ $post->comments_count }} komentar
            </a>
        </div>
    @endif

    <!-- Donation Progress -->
    <div class="px-4 pt-3 pb-4 border-t border-gray-200 dark:border-gray-800">
        <a href="{{ route('posts.show', $post->id) }}" class="block">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Terkumpul</p>
                    <p class="text-lg font-bold text-cyan-600 dark:text-cyan-400">
                        Rp {{ number_format($post->collected_amount ?? 0, 0, ',', '.') }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Target</p>
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Rp {{ number_format($post->target_amount ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- Progress Bar -->
            @php
                $percentage = $post->target_amount > 0 ? min(($post->collected_amount / $post->target_amount) * 100, 100) : 0;
            @endphp

            <div class="w-full bg-gray-200 dark:bg-gray-800 rounded-full h-1.5 overflow-hidden mb-2">
                <div class="bg-cyan-500 h-1.5 rounded-full transition-all duration-500"
                    style="width: {{ $percentage }}%"></div>
            </div>

            <div class="flex items-center justify-between text-xs text-gray-600 dark:text-gray-400">
                <span>{{ number_format($percentage, 1) }}% tercapai</span>
                <span>{{ $post->donors_count ?? 0 }} donatur</span>
            </div>
        </a>
    </div>
</div>

<script>
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
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
