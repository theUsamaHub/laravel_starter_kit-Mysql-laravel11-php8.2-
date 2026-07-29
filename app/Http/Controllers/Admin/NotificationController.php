<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $query = auth()->user()->notifications();

        if ($request->input('filter') === 'unread') {
            $query->whereNull('read_at');
        }

        $notifications = $query->latest()->paginate(30);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAsRead(DatabaseNotification $notification): RedirectResponse
    {
        $this->authorizeNotification($notification);
        $notification->markAsRead();

        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead(): RedirectResponse
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);

        cache()->forget('notifications.unread.' . auth()->id());

        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroy(DatabaseNotification $notification): RedirectResponse
    {
        $this->authorizeNotification($notification);
        $notification->delete();

        return back()->with('success', 'Notification deleted.');
    }

    private function authorizeNotification(DatabaseNotification $notification): void
    {
        if ($notification->notifiable_id !== auth()->id()) {
            abort(403);
        }
    }
}
