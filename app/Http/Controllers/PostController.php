<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'category_id' => 'required|exists:categories,id',
            'target_amount' => 'required|numeric|min:100000',
            'deadline' => 'nullable|date|after:today',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'status' => 'required|in:draft,active',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['current_amount'] = 0;

        // Handle multiple images upload
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('posts', 'public');
                $imagePaths[] = $path;
            }
        }
        $validated['images'] = $imagePaths;

        $post = Post::create($validated);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Kampanye berhasil dibuat!');
    }

    /**
     * Display the specified post.
     */
    public function show(Post $post)
    {
        $post->load([
            'user',
            'category',
            'comments' => function ($q) {
                 $q->whereNull('parent_id')
                ->with(['user', 'replies.user']);

            }

        ]);

        $post->loadCount(['likes', 'comments'])
             ->loadSum(['donations as current_amount' => function ($q) {
                 $q->where('payment_status', 'success');
             }], 'amount')
             ->loadCount(['donations as donors_count' => function ($q) {
                 $q->where('payment_status', 'success');
             }]);

        // Check if user has liked
        $hasLiked = false;
        if (Auth::check()) {
            $hasLiked = $post->likes()->where('user_id', Auth::id())->exists();
        }

        // Check if user is owner
        $isOwner = Auth::check() && $post->user_id === Auth::id();

        // Get top 10 donors
        $topDonors = DB::table('donations')
            ->select('user_id', DB::raw('SUM(amount) as total_donated'), DB::raw('COUNT(*) as donation_count'))
            ->where('post_id', $post->id)
            ->where('payment_status', 'success')
            ->groupBy('user_id')
            ->orderByDesc('total_donated')
            ->limit(10)
            ->get()
            ->map(function ($donor) {
                $donor->user = \App\Models\User::find($donor->user_id);
                return $donor;
            });

        // Get related posts
        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('status', 'active')
            ->withCount('likes')
            ->limit(3)
            ->get();

        $popularCategories = Category::query()
            ->withCount('posts')
            ->whereHas('posts')
            ->orderByDesc('posts_count')
            ->limit(5)
            ->get();

        return view('posts.show', compact('post', 'hasLiked', 'isOwner', 'topDonors', 'relatedPosts', 'popularCategories'));
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::orderBy('name')->get();
        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'category_id' => 'required|exists:categories,id',
            'target_amount' => 'required|numeric|min:100000',
            'deadline' => 'nullable|date|after:today',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'status' => 'required|in:draft,active,completed',
            'remove_images' => 'nullable|array',
        ]);

        // Handle image removal
        if ($request->has('remove_images') && $post->images) {
            $remainingImages = array_diff($post->images, $request->remove_images);

            // Delete removed images from storage
            foreach ($request->remove_images as $imageToRemove) {
                Storage::disk('public')->delete($imageToRemove);
            }

            $validated['images'] = array_values($remainingImages);
        } else {
            $validated['images'] = $post->images ?? [];
        }

        // Handle new images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('posts', 'public');
                $validated['images'][] = $path;
            }
        }

        $post->update($validated);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Kampanye berhasil diperbarui!');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete all images
        if ($post->images) {
            foreach ($post->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $post->delete();

        return redirect()
            ->route('home')
            ->with('success', 'Kampanye berhasil dihapus!');
    }
}
