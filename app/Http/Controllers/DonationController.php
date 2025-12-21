<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function create(Post $post)
    {
        if ($post->status !== 'active') {
            abort(404, 'Kampanye tidak aktif.');
        }
        return view('donations.create', compact('post'));
    }

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'payment_method' => 'required|string',
            'message' => 'nullable|string|max:500',
            'is_anonymous' => 'sometimes|boolean',
        ]);

        if ($post->status !== 'active') {
            return back()->withErrors(['post' => 'Kampanye tidak aktif.']);
        }

        $donation = DB::transaction(function () use ($request, $post) {
            $donation = auth()->user()->donations()->create([
                'post_id' => $post->id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'message' => $request->message,
                'is_anonymous' => $request->boolean('is_anonymous'),
                'payment_status' => 'success',
                'paid_at' => now(),
            ]);

            $post->update([
                'collected_amount' => DB::raw('collected_amount + ' . $request->amount)
            ]);

            return $donation;
        });

        NotificationHelper::createDonationNotification($donation);

        if ($post->collected_amount >= $post->target_amount) {
            NotificationHelper::createGoalReachedNotification($post);
        }

        return redirect()->route('posts.show', $post)
            ->with('success', 'Donasi berhasil, Terima kasih.');
    }

    public function history()
    {
        $user = Auth::user();


        $donations = $user->donations()
            ->with(['post.user'])
            ->where('payment_status', 'success')
            ->latest()
            ->paginate(15);

        $stats = [
            'total_donated' => $user->donations()
                ->where('payment_status', 'success')
                ->sum('amount'),

            'total_donations' => $user->donations()
                ->where('payment_status', 'success')
                ->count(),

            'this_month' => $user->donations()
                ->where('payment_status', 'success')
                ->whereBetween('created_at', [
                    now()->startOfMonth(),
                    now()->endOfMonth()
                ])
                ->sum('amount'),
        ];

        return view('donations.history', compact('donations', 'stats'));
    }
}
