<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyReport extends Model
{
    protected $fillable = [
        'user_id',
        'report_date',
        'total_activities',
        'completed_activities',
        'pending_activities',
        'missed_activities',
        'prayer_stats',
        'habit_stats',
        'activities',
        'finalized_at',
    ];

    protected $casts = [
        'report_date' => 'date',
        'prayer_stats' => 'array',
        'habit_stats' => 'array',
        'activities' => 'array',
        'finalized_at' => 'immutable_datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
