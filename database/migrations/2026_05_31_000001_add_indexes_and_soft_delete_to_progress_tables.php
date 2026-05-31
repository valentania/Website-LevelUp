<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add performance indexes to progress_messages and soft-delete support to mission_progresses.
     *
     * Indexes added:
     *   - mission_progress_id   → speeds up "load all messages for a chat room" query
     *   - sender_id             → speeds up "messages sent by user" query
     *   - created_at            → speeds up ?since= polling filter
     *   - (mission_progress_id, created_at) composite → optimal for ordered pagination
     *
     * SoftDeletes on mission_progresses:
     *   - Ensures deleted missions don't orphan progress records unexpectedly.
     */
    public function up(): void
    {
        // ── Indexes on progress_messages ─────────────────────────
        Schema::table('progress_messages', function (Blueprint $table) {
            // Individual indexes
            if (!$this->hasIndex('progress_messages', 'progress_messages_mission_progress_id_index')) {
                $table->index('mission_progress_id');
            }
            if (!$this->hasIndex('progress_messages', 'progress_messages_sender_id_index')) {
                $table->index('sender_id');
            }
            if (!$this->hasIndex('progress_messages', 'progress_messages_created_at_index')) {
                $table->index('created_at');
            }
            // Composite index optimal for paginated polling queries
            if (!$this->hasIndex('progress_messages', 'progress_messages_room_timeline_index')) {
                $table->index(['mission_progress_id', 'created_at'], 'progress_messages_room_timeline_index');
            }
        });

        // ── SoftDeletes on mission_progresses ────────────────────
        Schema::table('mission_progresses', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_progresses', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('progress_messages', function (Blueprint $table) {
            $table->dropIndexIfExists('progress_messages_mission_progress_id_index');
            $table->dropIndexIfExists('progress_messages_sender_id_index');
            $table->dropIndexIfExists('progress_messages_created_at_index');
            $table->dropIndexIfExists('progress_messages_room_timeline_index');
        });

        Schema::table('mission_progresses', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }

    /**
     * Helper: check whether an index already exists (prevents duplicate index errors on re-run).
     * Uses raw PDO SHOW INDEX to stay Doctrine-free (compatible with Laravel 11).
     */
    private function hasIndex(string $table, string $indexName): bool
    {
        $conn   = Schema::getConnection();
        $prefix = $conn->getTablePrefix();
        $rows   = $conn->select("SHOW INDEX FROM `{$prefix}{$table}` WHERE Key_name = ?", [$indexName]);
        return count($rows) > 0;
    }
};
