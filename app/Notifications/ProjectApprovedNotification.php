<?php

namespace App\Notifications;

use App\Models\MissionProgress;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectApprovedNotification extends Notification
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
            'type'    => 'project_approved',
            'icon'    => '🏆',
            'title'   => 'Project Disetujui!',
            'message' => "Selamat! Project kamu untuk mission \"" .
                         $this->progress->mission->title . "\" telah disetujui UMKM. Poin telah ditambahkan!",
            'url'     => route('mahasiswa.progress.show', $this->progress),
        ];
    }
}
