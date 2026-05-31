<?php

namespace App\Notifications;

use App\Models\Mission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MissionRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(public Mission $mission) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'mission_rejected',
            'icon'    => '',
            'title'   => 'Mission Ditolak',
            'message' => "Mission \"" . $this->mission->title . "\" ditolak oleh Admin." .
                         ($this->mission->rejection_reason ? " Alasan: " . $this->mission->rejection_reason : ''),
            'url'     => route('umkm.missions.show', $this->mission),
        ];
    }
}
