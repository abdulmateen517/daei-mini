<?php

use App\Http\Controllers\Api\ActivityReminderController;
use App\Http\Controllers\Api\DailySummaryController;
use App\Http\Controllers\Api\OfflineSyncController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->post('/offline-sync', [OfflineSyncController::class, 'sync']);
Route::middleware('auth:sanctum')->get('/daily-summary', [DailySummaryController::class, 'show']);
Route::middleware('auth:sanctum')->post('/daily-summary', [DailySummaryController::class, 'store']);
Route::middleware('auth:sanctum')->put('/daily-summary', [DailySummaryController::class, 'store']);
Route::middleware('auth:sanctum')->put(
    '/activities/{activity}/reminder',
    [ActivityReminderController::class, 'update']
);
