<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Mark a single notification as read, then redirect to its URL.
     */
    public function markRead(Request $request, string $id): RedirectResponse
    {
        $notification = $request->user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
            $url = $notification->data['url'] ?? null;
            if ($url) {
                return redirect()->to($url);
            }
        }

        return back();
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllRead(Request $request): RedirectResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    /**
     * Get unread notifications for AJAX polling.
     */
    public function getUnread(Request $request): \Illuminate\Http\JsonResponse
    {
        $unread = $request->user()->unreadNotifications;
        return response()->json([
            'count' => $unread->count(),
            'notifications' => $unread->map(function ($n) {
                return [
                    'id' => $n->id,
                    'title' => $n->data['title'] ?? 'Notifikasi Baru',
                    'message' => $n->data['message'] ?? '',
                    'icon' => $n->data['icon'] ?? '',
                    'url' => $n->data['url'] ?? '#',
                    'created_at' => $n->created_at->diffForHumans(),
                ];
            })
        ]);
    }
}
