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

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'category_id' => 'required|exists:categories,id',
            'target_amount' => 'required|numeric|min:100000',
            'deadline' => 'nullable|date|after:today',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'status' => 'required|in:draft,active',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['collected_amount'] = 0;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create($validated);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Kampanye berhasil dibuat!');
    }

    public function show(Post $post)
    {
        $post->load([
            'user',
            'category',
            'comments.user'
        ]);

        $post->loadCount(['likes', 'comments'])
             ->loadSum(['donations as current_amount' => function ($q) {
                 $q->where('payment_status', 'success');
             }], 'amount')

             ->loadCount(['donations as donors_count' => function ($q) {
                 $q->where('payment_status', 'success');
             }]);

        $hasLiked = false;
        if (Auth::check()) {
            $hasLiked = $post->likes()->where('user_id', Auth::id())->exists();
        }


        $isOwner = Auth::check() && $post->user_id === Auth::id();


        return view('posts.show', compact('post', 'hasLiked', 'isOwner' ));
    }



    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }


        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()
            ->route('home')
            ->with('success', 'Kampanye berhasil dihapus!');
    }
}
