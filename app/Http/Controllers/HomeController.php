<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'q' => 'nullable|string|max:100',
        ]);

        $q = trim($request->q);

        $posts = Post::query()
            ->with(['user', 'category'])
            ->withCount(['likes', 'comments'])
            ->withExists([
                'likes as isLikedByUser' => function ($query) {
                    $query->where('user_id', Auth::id() ?? 0);
                }
            ])

            ->when($q, function ($query) use ($q) {
                $query->where(function ($subQuery) use ($q) {
                    $subQuery->where('title', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%")
                        ->orWhereHas('user', function ($userQuery) use ($q) {
                            $userQuery->where('name', 'like', "%{$q}%");
                        })
                        ->orWhereHas('category', function ($catQuery) use ($q) {
                            $catQuery->where('name', 'like', "%{$q}%");
                        });
                });
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('home', [
            'posts' => $posts,
            'q' => $q,
            'isSearching' => filled($q),
        ]);
    }
}
