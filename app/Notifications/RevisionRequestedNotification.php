<?php

namespace App\Notifications;

use App\Models\MissionProgress;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RevisionRequestedNotification extends Notification
{
    use Queueable;

    public function __construct(public MissionProgress $progress) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'revision_requested',
            'icon'    => '🔄',
            'title'   => 'Revisi Diminta',
            'message' => "UMKM meminta revisi untuk project kamu di mission \"" .
                         $this->progress->mission->title . "\". Cek catatan revisi dan kirim ulang.",
            'url'     => route('mahasiswa.progress.show', $this->progress),
        ];
    }
}
