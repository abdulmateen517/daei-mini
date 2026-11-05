# daei-mini
A mobile productivity and personal development application featuring personalized timetables, prayer tracking, habits, daily self-assessment, and offline-first support.

## Offline record sync API

The Laravel API implementation is in `routes/api.php`, with its controller, model, and migration in the conventional `app/` and `database/migrations/` directories. Run the migration in a Laravel application with a standard `users` table and Sanctum configured. The route requires an authenticated Sanctum user, and records are stored per user in `offline_sync_records`.

Send a `POST /api/offline-sync` request with a non-empty `items` array. Use `type` values `timetable` or `journal`. Each item accepts either `client_id` or `uuid` (if both are sent, they must match), an `action` of `create` or `update`, the original `created_at`, the client `submitted_at`, and a `data` object:

```json
{
  "items": [
    {
      "client_id": "8b41f301-7aca-4c28-a7e6-77c74b9d1c30",
      "type": "timetable",
      "action": "create",
      "created_at": "2026-11-05T08:30:00Z",
      "submitted_at": "2026-11-05T09:00:00Z",
      "data": {
        "title": "Study",
        "starts_at": "2026-11-06T10:00:00Z"
      }
    }
  ]
}
```

The response includes one result per item. `synced` means the item was created or updated; `already_synced` means a retried `create` matched an existing client ID and was left unchanged. Both statuses indicate that the client can mark the item as synced. An `update` for an unseen client ID is inserted, allowing updates to arrive before their original create.

```json
{
  "success": true,
  "items": [
    {
      "client_id": "8b41f301-7aca-4c28-a7e6-77c74b9d1c30",
      "type": "timetable",
      "status": "synced"
    }
  ]
}
```

## Activity and prayer reminders

Scheduled activity records (including `prayer`, `study`, and `workout`) are stored in `scheduled_activities`. The authenticated user can toggle a reminder for one of their scheduled activity IDs:

```http
PUT /api/activities/42/reminder
Authorization: Bearer <sanctum-token>
Content-Type: application/json
```

Set `enabled` to `true` or `false`. When setting a reminder, provide either an absolute `reminder_time` timestamp or a `minutes_before` offset from the activity's `starts_at` (0–10080 minutes). Existing reminder settings are retained when toggling an already-configured reminder without changing its timing. Disabling a reminder does not discard its timing.

```json
{
  "enabled": true,
  "minutes_before": 15
}
```

The endpoint is implemented by `ActivityReminderController` and `ActivityReminderService`. Laravel's scheduler runs `activities:send-reminders` every minute through `routes/console.php`; configure the system scheduler to run `php artisan schedule:run` every minute. The command records a database notification and marks the reminder sent atomically, so overlapping command runs do not duplicate notifications. The Laravel `User` model must use `Illuminate\Notifications\Notifiable`; this implementation includes the standard `notifications` table migration.

## Daily summary API

Authenticated users can generate and finalize (or re-finalize) their report for today with `POST /api/daily-summary`; `PUT /api/daily-summary` uses the same operation to refresh an existing report. The optional `date` must be today in the configured application timezone; past and future dates are rejected. The server builds the report from the signed-in user's `scheduled_activities` and stores a snapshot in `daily_reports`, so submitted counts cannot be supplied by the client.

Activities with a non-null `completed_at` are completed. Incomplete activities whose `starts_at` is before the current time are missed; the rest are pending. Activities of type `prayer` and `habit` are also included in their respective completion statistics. Run the migrations to add activity completion tracking and daily report storage.

```json
{
  "date": "2026-11-05"
}
```
