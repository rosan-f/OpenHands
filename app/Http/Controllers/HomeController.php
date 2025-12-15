<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->with(['user', 'category'])
            ->withCount(['likes', 'comments'])
            ->withExists([
                'likes as isLikedByUser' => function ($q) {
                    $q->where('user_id', Auth::id() ?? 0);
                }
            ])
            ->latest()
            ->paginate(10);

        return view('home', compact('posts'));
    }
}
