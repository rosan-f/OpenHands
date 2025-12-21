<?php


namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Toggle like on a post
     */
    public function toggle(Post $post)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $like = Like::where('post_id', $post->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($like) {
            $like->delete();
            $liked = false;

        } else {

            Like::create([
                'post_id' => $post->id,
                'user_id' => Auth::id(),
            ]);
            $liked = true;

            if ($post->user_id !== auth()->id()) {
                NotificationHelper::createLikeNotification($like);
    }
        }

        $likesCount = $post->likes()->count();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'liked' => $liked,
                'likes_count' => $likesCount,
            ]);
        }

        return back();
    }
}
