<?php

namespace App\Notifications;

use App\Models\ScheduledActivity;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ActivityReminderNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly ScheduledActivity $activity)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'activity_id' => $this->activity->id,
            'type' => $this->activity->type,
            'title' => $this->activity->title,
            'starts_at' => $this->activity->starts_at->toIso8601String(),
            'message' => "Your {$this->activity->type} activity is coming up.",
        ];
    }
}
