<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\MissionProgress;
use App\Models\ProgressMessage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class ProgressMessageController extends Controller
{
    /**
     * Resolve whether the authenticated user is either the mahasiswa
     * who owns the progress OR the UMKM who owns the mission.
     *
     * Uses mission_id FK directly (always present) and loads the mission
     * with withTrashed() so soft-deleted missions don't break access.
     *
     * @return array{isMahasiswa: bool, isUmkm: bool}
     */
    private function resolveAccess(Request $request, MissionProgress $progress): array
    {
        $user = $request->user();

        // Mahasiswa check — direct FK comparison, no relationship needed
        $isMahasiswa = (int) $user->id === (int) $progress->user_id;

        // UMKM check — verify role first (cheap), then load mission with
        // withTrashed() so soft-deleted missions still allow chat access.
        $isUmkm = false;
        if ($user->isUmkm() && $progress->mission_id) {
            // Single query: SELECT user_id FROM missions WHERE id = ? (including trashed)
            $missionOwnerId = Mission::withTrashed()
                ->where('id', $progress->mission_id)
                ->value('user_id');

            $isUmkm = $missionOwnerId !== null
                && (int) $user->id === (int) $missionOwnerId;
        }

        return ['isMahasiswa' => $isMahasiswa, 'isUmkm' => $isUmkm];
    }

    /**
     * Return messages for a progress (JSON — used by real-time polling).
     *
     * Supports pagination via ?per_page (default 50, max 100) and
     * filtering via ?since (ISO 8601 timestamp).
     */
    public function index(Request $request, MissionProgress $progress): JsonResponse
    {
        // ── Authorization ────────────────────────────────────────
        $access = $this->resolveAccess($request, $progress);

        if (! $access['isMahasiswa'] && ! $access['isUmkm']) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        // ── Validate query params ────────────────────────────────
        $request->validate([
            'since'    => ['nullable', 'date'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $user    = $request->user();
        $perPage = min((int) ($request->query('per_page', 50)), 100);

        // ── Build query with eager loading ───────────────────────
        $query = $progress->messages()
            ->with(['sender', 'sender.umkmProfile'])
            ->orderBy('created_at', 'asc');

        // Filter by timestamp (polling "since last seen")
        $since = $request->query('since');
        if ($since) {
            try {
                $sinceDate = Carbon::parse($since);
                $query->where('created_at', '>', $sinceDate);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Invalid "since" date format. Use ISO 8601.',
                ], 422);
            }
        }

        // ── Paginate ─────────────────────────────────────────────
        $paginator = $query->paginate($perPage);

        $messages = collect($paginator->items())->map(function ($msg) use ($user) {
            $isMe = (int) $msg->sender_id === (int) $user->id;
            return [
                'id'         => $msg->id,
                'isMe'       => $isMe,
                'sender'     => $isMe
                    ? 'Kamu'
                    : ($msg->sender?->umkmProfile?->business_name
                        ?? $msg->sender?->name
                        ?? 'Unknown'),
                'message'    => $msg->message,
                'created_at' => $msg->created_at->format('d M H:i'),
                'ts'         => $msg->created_at->toIso8601String(),
            ];
        });

        return response()->json([
            'messages'    => $messages,
            'pagination'  => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
            ],
        ]);
    }

    /**
     * Store a new message (AJAX or form POST).
     */
    public function store(Request $request, MissionProgress $progress): RedirectResponse|JsonResponse
    {
        // ── Authorization ────────────────────────────────────────
        $access = $this->resolveAccess($request, $progress);

        if (! $access['isMahasiswa'] && ! $access['isUmkm']) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized.'], 403);
            }
            abort(403, 'Unauthorized action.');
        }

        // ── Validation ───────────────────────────────────────────
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        // ── Create message ───────────────────────────────────────
        $user = $request->user();

        $msg = ProgressMessage::create([
            'mission_progress_id' => $progress->id,
            'sender_id'           => $user->id,
            'message'             => $validated['message'],
        ]);

        // ── Response ─────────────────────────────────────────────
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => [
                    'id'         => $msg->id,
                    'isMe'       => true,
                    'sender'     => 'Kamu',
                    'message'    => $msg->message,
                    'created_at' => $msg->created_at->format('d M H:i'),
                    'ts'         => $msg->created_at->toIso8601String(),
                ],
            ], 201);
        }

        return back()->with('success', 'Pesan terkirim.');
    }
}
