<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function seeAllNotifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pages.shared.notifications', compact('notifications'));
    }
    public function getAllNotifications()
    {
        $ALL_NOTIFICATIONS = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        return response()->json($ALL_NOTIFICATIONS);
    }

    public function getUnreadNotificationsCount()
    {
        $NO_OF_UNREAD_NOTIFICATIONS = Notification::where('user_id', Auth::id())
            ->where('if_read', 0)
            ->count();

        return $NO_OF_UNREAD_NOTIFICATIONS;
    }


    public function toggleIfRead(Notification $notification)
    {
        $notification->if_read = !$notification->if_read;
        $notification->save();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('if_read', 0)
            ->update(['if_read' => 1]);

        return response()->json(['success' => true]);
    }

    public function getToggleIfRead(Notification $notification)
    {
        $notification->if_read = !$notification->if_read;
        $notification->save();

        return redirect()->back();
    }

    public function getMarkAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('if_read', 0)
            ->update(['if_read' => 1]);

        return redirect()->back();
    }
}
