<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ScheduledActivity;
use App\Services\ActivityReminderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActivityReminderController extends Controller
{
    public function update(
        Request $request,
        ScheduledActivity $activity,
        ActivityReminderService $reminders
    ): JsonResponse {
        abort_unless(
            (string) $activity->user_id === (string) $request->user()->getAuthIdentifier(),
            404
        );

        $validator = Validator::make($request->all(), [
            'enabled' => ['required', 'boolean'],
            'reminder_time' => ['nullable', 'date'],
            'minutes_before' => ['nullable', 'integer', 'min:0', 'max:10080'],
        ]);

        $validator->after(function ($validator) use ($request, $activity): void {
            if (
                $request->filled('reminder_time')
                && $request->filled('minutes_before')
            ) {
                $validator->errors()->add(
                    'reminder_time',
                    'Choose either reminder_time or minutes_before, not both.'
                );
            }

            if (
                $request->boolean('enabled')
                && ! $request->filled('reminder_time')
                && ! $request->filled('minutes_before')
                && $activity->reminder_at === null
            ) {
                $validator->errors()->add(
                    'reminder_time',
                    'Provide a reminder_time or minutes_before to enable reminders.'
                );
            }
        });

        $validated = $validator->validate();
        $activity = $reminders->updateReminder(
            $activity,
            (bool) $validated['enabled'],
            $validated['reminder_time'] ?? null,
            isset($validated['minutes_before']) ? (int) $validated['minutes_before'] : null
        );

        return response()->json([
            'data' => [
                'activity_id' => $activity->id,
                'type' => $activity->type,
                'title' => $activity->title,
                'enabled' => $activity->reminder_enabled,
                'reminder_time' => $activity->reminder_time?->toIso8601String(),
                'minutes_before' => $activity->minutes_before,
                'reminder_at' => $activity->reminder_at?->toIso8601String(),
            ],
        ]);
    }
}
