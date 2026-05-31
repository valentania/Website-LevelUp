<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressMessage extends Model
{
    protected $fillable = [
        'mission_progress_id',
        'sender_id',
        'message',
    ];

    public function progress()
    {
        return $this->belongsTo(MissionProgress::class, 'mission_progress_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
