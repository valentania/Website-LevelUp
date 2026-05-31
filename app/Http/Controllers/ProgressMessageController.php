<?php

namespace App\Http\Controllers;

use App\Models\MissionProgress;
use App\Models\ProgressMessage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class ProgressMessageController extends Controller
{
    /**
     * Return all messages for a progress (JSON — used by real-time polling).
     */
    public function index(Request $request, MissionProgress $progress): JsonResponse
    {
        $progress->loadMissing('mission');
        $isMahasiswa = (int)$request->user()->id === (int)$progress->user_id;
        $isUmkm      = $request->user()->isUmkm() && $progress->mission && (int)$request->user()->id === (int)$progress->mission->user_id;

        if (!$isMahasiswa && !$isUmkm) {
            abort(403);
        }

        $since = $request->query('since'); // timestamp filter

        $query = $progress->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc');

        if ($since) {
            $query->where('created_at', '>', $since);
        }

        $messages = $query->get()->map(function ($msg) use ($request) {
            $isMe = $msg->sender_id === $request->user()->id;
            return [
                'id'         => $msg->id,
                'isMe'       => $isMe,
                'sender'     => $isMe ? 'Kamu' : ($msg->sender->umkmProfile?->business_name ?? $msg->sender->name),
                'message'    => $msg->message,
                'created_at' => $msg->created_at->format('d M H:i'),
                'ts'         => $msg->created_at->toIso8601String(),
            ];
        });

        return response()->json(['messages' => $messages]);
    }

    /**
     * Store a new message (AJAX or form POST).
     */
    public function store(Request $request, MissionProgress $progress): RedirectResponse|JsonResponse
    {
        $progress->loadMissing('mission');
        $isMahasiswa = (int)$request->user()->id === (int)$progress->user_id;
        $isUmkm      = $request->user()->isUmkm() && $progress->mission && (int)$request->user()->id === (int)$progress->mission->user_id;

        if (!$isMahasiswa && !$isUmkm) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $msg = ProgressMessage::create([
            'mission_progress_id' => $progress->id,
            'sender_id'           => $request->user()->id,
            'message'             => $validated['message'],
        ]);

        $msg->load('sender');
        $isMe = $msg->sender_id === $request->user()->id;

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => [
                    'id'         => $msg->id,
                    'isMe'       => $isMe,
                    'sender'     => 'Kamu',
                    'message'    => $msg->message,
                    'created_at' => $msg->created_at->format('d M H:i'),
                    'ts'         => $msg->created_at->toIso8601String(),
                ],
            ]);
        }

        return back()->with('success', 'Pesan terkirim.');
    }
}
