<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DailySummaryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DailySummaryController extends Controller
{
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
