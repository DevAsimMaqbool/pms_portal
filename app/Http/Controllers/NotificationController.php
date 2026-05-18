<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()
            ->user()
            ->notifications()
            ->latest()
            ->paginate(20);

        return view(
            'notifications.index',
            compact('notifications')
        );
    }

    public function markAsRead($id)
    {
        $notification = auth()
            ->user()
            ->notifications()
            ->find($id);

        if ($notification) {

            $notification->markAsRead();
        }

        return back();
    }

    public function markAllAsRead()
    {
        auth()
            ->user()
            ->unreadNotifications
            ->markAsRead();

        return back();
    }
}