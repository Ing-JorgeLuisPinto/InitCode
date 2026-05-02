<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Mark all as read when viewing
        Notification::where('user_id', auth()->id())
            ->where('read', false)
            ->update(['read' => true]);

        return view('notifications.index', compact('notifications'));
    }

    public function markRead(Notification $notification)
    {
        if ($notification->user_id === auth()->id()) {
            $notification->update(['read' => true]);
        }

        if ($notification->link) {
            return redirect($notification->link);
        }
        return back();
    }

    public function readAll()
    {
        Notification::where('user_id', auth()->id())
            ->where('read', false)
            ->update(['read' => true]);

        return back()->with('success', '✅ Todas las notificaciones marcadas como leídas');
    }

    public function unreadCount()
    {
        $count = Notification::where('user_id', auth()->id())
            ->where('read', false)
            ->count();

        return response()->json(['count' => $count]);
    }
}
