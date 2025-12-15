<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Share;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShareController extends Controller
{
    /**
     * Record a share action
     */
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'platform' => 'nullable|string|in:facebook,twitter,whatsapp,telegram,copy',
        ]);

        if (Auth::check()) {
            Share::create([
                'post_id' => $post->id,
                'user_id' => Auth::id(),
                'platform' => $validated['platform'] ?? 'copy',
                'share_url' => route('posts.show', $post->id),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih telah membagikan kampanye ini!',
        ]);
    }
}
