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
        'work_summary', 'challenges', 'learning', 'rating', 'reflection', 'review_status',
    ];

    protected $casts = [
        'report_date' => 'date',
        'prayer_stats' => 'array',
        'habit_stats' => 'array',
        'activities' => 'array',
        'finalized_at' => 'immutable_datetime',
        'rating' => 'integer',
    ];
    protected $appends = ['completion_percentage'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function feedback() { return $this->hasMany(DailyReportFeedback::class)->with('admin')->latest(); }
    public function getCompletionPercentageAttribute(): int
    {
        return $this->total_activities ? (int) round($this->completed_activities * 100 / $this->total_activities) : 0;
    }
}
