<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{

    public function index()
    {
        $bookmarks = Bookmark::where('user_id', Auth::id())
            ->with('post.user', 'post.category')
            ->latest()
            ->paginate(10);

        return view('bookmarks.index', compact('bookmarks'));
    }


    public function toggle(Post $post)
    {
        $bookmark = Bookmark::where('user_id', Auth::id())
            ->where('post_id', $post->id)
            ->first();

        if ($bookmark) {

            $bookmark->delete();
            return back()->with('success', 'Post dihapus dari bookmark');
        } else {


            Bookmark::create([
                'user_id' => Auth::id(),
                'post_id' => $post->id,
            ]);

            return back()->with('success', 'Post ditambahkan ke bookmark');
        }
    }


    public function destroy(Bookmark $bookmark)
    {
        if ($bookmark->user_id !== Auth::id()) {
            abort(403);
        }

        $bookmark->delete();
        return back()->with('success', 'Bookmark berhasil dihapus');
    }
}
