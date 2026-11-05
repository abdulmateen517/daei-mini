<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfflineSyncRecord extends Model
{
    protected $casts = [
        'data' => 'array',
        'original_created_at' => 'immutable_datetime',
        'submitted_at' => 'immutable_datetime',
    ];

    protected $fillable = [
        'user_id',
        'client_id',
        'type',
        'data',
        'original_created_at',
        'submitted_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
