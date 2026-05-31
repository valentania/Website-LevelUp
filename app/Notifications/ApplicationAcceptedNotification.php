<?php

namespace App\Notifications;

use App\Models\Mission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationAcceptedNotification extends Notification
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
            'type'    => 'application_accepted',
            'icon'    => '🎉',
            'title'   => 'Lamaran Diterima!',
            'message' => "Lamaranmu untuk mission \"" . $this->mission->title . "\" telah diterima. Segera mulai kerjakan!",
            'url'     => route('mahasiswa.applications.index'),
        ];
    }
}
