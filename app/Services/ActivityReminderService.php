<?php

namespace App\Services;

use App\Models\ScheduledActivity;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class ActivityReminderService
{
    public function updateReminder(
        ScheduledActivity $activity,
        bool $enabled,
        ?string $reminderTime,
        ?int $minutesBefore
    ): ScheduledActivity {
        if ($reminderTime !== null && $minutesBefore !== null) {
            throw ValidationException::withMessages([
                'reminder_time' => 'Choose either reminder_time or minutes_before, not both.',
            ]);
        }

        $reminderAt = match (true) {
            $reminderTime !== null => Carbon::parse($reminderTime)
                ->setTimezone(config('app.timezone', 'UTC')),
            $minutesBefore !== null => $activity->starts_at->subMinutes($minutesBefore),
            default => $activity->reminder_at,
        };

        if ($enabled && $reminderAt === null) {
            throw ValidationException::withMessages([
                'reminder_time' => 'Provide a reminder_time or minutes_before to enable reminders.',
            ]);
        }

        $scheduleChanged = $activity->reminder_at?->format('U.u')
            !== $reminderAt?->format('U.u');

        $reminderTimeValue = $reminderTime !== null
            ? $reminderAt
            : $activity->reminder_time;
        $minutesBeforeValue = $minutesBefore ?? $activity->minutes_before;

        if ($reminderTime !== null || $minutesBefore !== null) {
            $reminderTimeValue = $reminderTime;
            $minutesBeforeValue = $minutesBefore;
        }

        $activity->fill([
            'reminder_enabled' => $enabled,
            'reminder_time' => $reminderTimeValue,
            'minutes_before' => $minutesBeforeValue,
            'reminder_at' => $reminderAt,
            'reminder_sent_at' => $scheduleChanged ? null : $activity->reminder_sent_at,
        ])->save();

        return $activity->refresh();
    }
}
