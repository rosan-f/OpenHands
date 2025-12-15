<?php

// ============================================================
// app/Http/Controllers/ProofController.php
// ============================================================

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Proof;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProofController extends Controller
{
    /**
     * Store proof for a post.
     */
    public function store(Request $request, Post $post)
    {
        // Check authorization
        if ($post->user_id !== Auth::id()) {
            return redirect()
                ->back()
                ->with('error', 'Anda tidak memiliki akses untuk mengunggah bukti!');
        }

        // Check if target reached
        if ($post->current_amount < $post->target_amount) {
            return redirect()
                ->back()
                ->with('error', 'Dana belum mencapai target!');
        }

        // Check if proof already exists
        if ($post->proof) {
            return redirect()
                ->back()
                ->with('error', 'Bukti sudah pernah diupload!');
        }

        $validated = $request->validate([
            'description' => 'required|string|min:20',
            'images.*' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        // Upload images
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('proofs', 'public');
                $imagePaths[] = $path;
            }
        }

        // Create proof
        Proof::create([
            'post_id' => $post->id,
            'description' => $validated['description'],
            'images' => $imagePaths,
        ]);

        // Update post status
        $post->update(['status' => 'completed']);

        return redirect()
            ->route('posts.show', ['post' => $post->id, 'tab' => 'proof'])
            ->with('success', 'Bukti pencairan dana berhasil diunggah!');
    }

    /**
     * Update proof.
     */
    public function update(Request $request, Post $post, Proof $proof)
    {
        // Check authorization
        if ($post->user_id !== Auth::id()) {
            return redirect()
                ->back()
                ->with('error', 'Anda tidak memiliki akses!');
        }

        $validated = $request->validate([
            'description' => 'required|string|min:20',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        // Upload new images if provided
        if ($request->hasFile('images')) {
            // Delete old images
            if ($proof->images) {
                foreach ($proof->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('proofs', 'public');
                $imagePaths[] = $path;
            }
            $validated['images'] = $imagePaths;
        }

        $proof->update($validated);

        return redirect()
            ->route('posts.show', ['post' => $post->id, 'tab' => 'proof'])
            ->with('success', 'Bukti berhasil diperbarui!');
    }

    /**
     * Delete proof.
     */
    public function destroy(Post $post, Proof $proof)
    {
        // Check authorization
        if ($post->user_id !== Auth::id()) {
            return redirect()
                ->back()
                ->with('error', 'Anda tidak memiliki akses!');
        }

        // Delete images
        if ($proof->images) {
            foreach ($proof->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $proof->delete();

        return redirect()
            ->route('posts.show', ['post' => $post->id, 'tab' => 'proof'])
            ->with('success', 'Bukti berhasil dihapus!');
    }
}
