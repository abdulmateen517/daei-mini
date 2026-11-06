<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Services\DailySummaryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DailySummaryController extends Controller
{
    public function show(Request $request, DailySummaryService $summaries): JsonResponse
    {
        $validated = Validator::make($request->query(), [
            'date' => ['sometimes', 'required', 'date_format:Y-m-d'],
        ])->validate();

        $date = $validated['date'] ?? now(config('app.timezone'))->toDateString();
        $today = now(config('app.timezone'))->toDateString();
        if ($date !== $today) {
            throw ValidationException::withMessages([
                'date' => 'Daily summaries are only available for the current date.',
            ]);
        }

        $report = DailyReport::query()
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->whereDate('report_date', $date)
            ->first();

        return response()->json([
            'data' => $report ?? $summaries->generate(
                $request->user()->getAuthIdentifier(),
                $date
            ),
        ]);
    }

    public function store(Request $request, DailySummaryService $summaries): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'date' => ['sometimes', 'required', 'date_format:Y-m-d'],
        ])->validate();

        $date = $validated['date'] ?? now(config('app.timezone'))->toDateString();
        $report = $summaries->finalize(
            $request->user()->getAuthIdentifier(),
            $date
        );

        return response()->json(['data' => $report]);
    }
}
