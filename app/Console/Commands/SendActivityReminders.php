<?php

namespace App\Console\Commands;

use App\Models\ScheduledActivity;
use App\Notifications\ActivityReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendActivityReminders extends Command
{
    protected $signature = 'activities:send-reminders';

    protected $description = 'Send due reminders for upcoming scheduled activities';

    public function handle(): int
    {
        $now = now();
        $sent = 0;

        ScheduledActivity::query()
            ->where('reminder_enabled', true)
            ->whereNull('reminder_sent_at')
            ->whereNotNull('reminder_at')
            ->where('reminder_at', '<=', $now)
            ->where('starts_at', '>=', $now)
            ->orderBy('id')
            ->chunkById(100, function ($activities) use (&$sent): void {
                foreach ($activities as $activity) {
                    $wasSent = DB::transaction(function () use ($activity): bool {
                        $dueAt = now();
                        $lockedActivity = ScheduledActivity::query()
                            ->whereKey($activity->getKey())
                            ->lockForUpdate()
                            ->first();

                        if (
                            $lockedActivity === null
                            || ! $lockedActivity->reminder_enabled
                            || $lockedActivity->reminder_sent_at !== null
                            || $lockedActivity->reminder_at === null
                            || $lockedActivity->reminder_at->isAfter($dueAt)
                            || $lockedActivity->starts_at->isBefore($dueAt)
                        ) {
                            return false;
                        }

                        $user = $lockedActivity->user;
                        if ($user === null) {
                            throw new \RuntimeException(
                                "Scheduled activity {$lockedActivity->getKey()} has no user."
                            );
                        }

                        $user->notify(new ActivityReminderNotification($lockedActivity));

                        $lockedActivity->forceFill(['reminder_sent_at' => $dueAt])->save();

                        return true;
                    });

                    if ($wasSent) {
                        $sent++;
                    }
                }
            });

        $this->info("Sent {$sent} activity reminder(s).");

        return self::SUCCESS;
    }
}
