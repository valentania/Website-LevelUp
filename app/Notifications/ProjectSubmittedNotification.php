<?php

namespace App\Notifications;

use App\Models\MissionProgress;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectSubmittedNotification extends Notification
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
            'type'    => 'project_submitted',
            'icon'    => '',
            'title'   => 'Hasil Project Dikirim',
            'message' => $this->progress->mahasiswa->name . " telah mengirim hasil project untuk mission \"" .
                         $this->progress->mission->title . "\". Segera tinjau!",
            'url'     => route('umkm.missions.show', $this->progress->mission),
        ];
    }
}
