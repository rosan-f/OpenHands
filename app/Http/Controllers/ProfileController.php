<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index($id = null)
    {
        $user = $id ? User::findOrFail($id) : Auth::user();
        $isOwnProfile = Auth::check() && Auth::id() === $user->id;

        $posts = $user->posts()
            ->with(['user', 'category'])
            ->withCount(['likes', 'comments', 'donations'])
            ->latest()
            ->paginate(12);

        $stats = [
            'posts' => $user->posts()->count(),
            'donations_made' => $user->donations()->where('payment_status', 'success')->count(),
            'total_donated' => $user->donations()->where('payment_status', 'success')->sum('amount'),
            'total_received' => $user->posts()->sum('collected_amount'),
            'active_campaigns' => $user->posts()->where('status', 'active')->count(),
        ];

        return view('profile.index', compact('user', 'posts', 'stats', 'isOwnProfile'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:500'],
            'location' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return redirect()->route('profile.index')
            ->with('success', 'Profil berhasil diperbarui');
    }





}
