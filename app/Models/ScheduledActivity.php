<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduledActivity extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'starts_at',
        'completed_at',
        'reminder_enabled',
        'reminder_time',
        'minutes_before',
        'reminder_at',
        'reminder_sent_at',
    ];

    protected $casts = [
        'starts_at' => 'immutable_datetime',
        'completed_at' => 'immutable_datetime',
        'reminder_enabled' => 'boolean',
        'reminder_time' => 'immutable_datetime',
        'reminder_at' => 'immutable_datetime',
        'reminder_sent_at' => 'immutable_datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
