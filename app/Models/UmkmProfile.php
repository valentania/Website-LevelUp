<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UmkmProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'business_type',
        'business_description',
        'address',
        'city',
        'phone',
        'website',
        'missions_posted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
