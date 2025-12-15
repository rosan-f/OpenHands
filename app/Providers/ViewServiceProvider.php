<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer([
            'partials.sidebar-left',
            'partials.sidebar-right',
        ], function ($view) {

            $sidebarData = Cache::remember('sidebar_data', 300, function () {
                return [
                    'popularCategories' => Category::withCount('posts')
                        ->whereHas('posts')
                        ->orderByDesc('posts_count')
                        ->limit(5)
                        ->get(),

                    'latestPosts' => Post::latest()
                        ->select('id', 'title')
                        ->limit(5)
                        ->get(),
                ];
            });

            $view->with($sidebarData);
        });
    }
}
