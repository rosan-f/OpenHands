<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Category;


class HomeController extends Controller
{


    public function index()
    {
        $posts = Post::with(['user', 'category'])
            ->latest()
            ->paginate(10);

        $popularCategories = Category::withCount('posts')
        ->whereHas('posts') 
        ->orderByDesc('posts_count')
        ->limit(5)
        ->get();


        return view('home', compact('posts', 'popularCategories'));
    }


}
