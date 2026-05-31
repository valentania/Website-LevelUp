<?php

namespace App\Notifications;

use App\Models\Mission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MissionApprovedNotification extends Notification
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
            'type'    => 'mission_approved',
            'icon'    => '',
            'title'   => 'Mission Disetujui',
            'message' => "Mission \"" . $this->mission->title . "\" telah disetujui oleh Admin dan sekarang aktif.",
            'url'     => route('umkm.missions.show', $this->mission),
        ];
    }
}
