<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()
            ->with(['relatedUser', 'relatedPost'])
            ->latest()
            ->paginate(20);

        $unreadCount = Auth::user()->notifications()->unread()->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        if ($notification->action_url) {
            return redirect($notification->action_url);
        }

        return back();
    }

    public function markAllAsRead()
    {
        Notification::markAllAsRead(Auth::id());

        return back()->with('success', 'Semua notifikasi telah dibaca');
    }

    public function getUnreadCount()
    {
        return response()->json([
            'count' => Auth::user()->unread_notifications_count
        ]);
    }
}
