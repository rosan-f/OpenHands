<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    public function create(Post $post)
    {
        if ($post->status !== 'active') {
            abort(404, 'Kampanye tidak tersedia untuk donasi.');
        }

        return view('donations.create', compact('post'));
    }

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000|max:1000000000',
            'message' => 'nullable|string|max:500',
            'is_anonymous' => 'sometimes|boolean',
            'payment_method' => 'required|string', 
        ]);

        if ($post->status !== 'active') {
            return back()->withErrors(['post' => 'Kampanye tidak aktif.']);
        }

        DB::transaction(function () use ($request, $post) {
            auth()->user()->donations()->create([
                'post_id' => $post->id,
                'amount' => $request->amount,
                'message' => $request->message,
                'is_anonymous' => $request->boolean('is_anonymous'),
                'payment_method' => $request->payment_method ?? 'manual',
                'payment_status' => 'success',
                'paid_at' => now(),
            ]);

            $post->update([
                'collected_amount' => DB::raw('collected_amount + ' . $request->amount)
            ]);

        });

        return redirect()->route('posts.show', $post)
            ->with('success', 'Donasi Anda berhasil! Terima kasih atas dukungannya.');
    }
}
