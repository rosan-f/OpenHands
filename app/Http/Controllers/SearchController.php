<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'q' => 'nullable|string|max:100',
        ]);

        $q = trim($request->q);

        $posts = Post::query()
        ->when($q, function ($query) use ($q) {
          $query->where(function ($subQuery) use ($q) {
              $subQuery->where('title', 'like', "%{$q}%")
                 ->orWhere('description', 'like', "%{$q}%")
                 ->orWhereHas('user', function ($userQuery) use ($q) {
                     $userQuery->where('name', 'like', "%{$q}%");
                 });
           });
        })


            ->where('status', 'active')
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
