<?php

namespace App\Notifications;

use App\Models\Mission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationRejectedNotification extends Notification
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
            'type'    => 'application_rejected',
            'icon'    => '😔',
            'title'   => 'Lamaran Tidak Diterima',
            'message' => "Lamaranmu untuk mission \"" . $this->mission->title . "\" belum berhasil kali ini. Tetap semangat!",
            'url'     => route('mahasiswa.missions.browse'),
        ];
    }
}
