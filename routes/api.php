<?php

use App\Http\Controllers\Api\ActivityReminderController;
use App\Http\Controllers\Api\AdminDashboardController;
use App\Http\Controllers\Api\AdminReportController;
use App\Http\Controllers\Api\DailyReportController;
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

Route::middleware('auth:sanctum')->group(function (): void {
    Route::get('/user', fn (\Illuminate\Http\Request $request) => $request->user());
    Route::get('/daily-reports', [DailyReportController::class, 'index']);
    Route::post('/daily-reports', [DailyReportController::class, 'store']);
    Route::get('/daily-reports/{report}', [DailyReportController::class, 'show']);
    Route::middleware('admin')->prefix('admin')->group(function (): void {
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);
        Route::get('/users', [AdminDashboardController::class, 'users']);
        Route::get('/users/{user}', [AdminDashboardController::class, 'user']);
        Route::get('/groups', [AdminDashboardController::class, 'groups']);
        Route::get('/groups/{group}', [AdminDashboardController::class, 'group']);
        Route::get('/reports', [AdminReportController::class, 'index']);
        Route::get('/reports/{report}', [AdminReportController::class, 'show']);
        Route::post('/reports/{report}/feedback', [AdminReportController::class, 'feedback']);
        Route::patch('/reports/{report}/status', [AdminReportController::class, 'status']);
    });
});
