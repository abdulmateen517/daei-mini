<?php

use App\Http\Controllers\Api\ActivityReminderController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\DailySummaryController;
use App\Http\Controllers\Api\OfflineSyncController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:6,1')->group(function (): void {
    Route::post('/register', [AuthenticationController::class, 'register']);
    Route::post('/login', [AuthenticationController::class, 'login']);
    Route::post('/admin/login', [AuthenticationController::class, 'adminLogin']);
});

Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/user', [AuthenticationController::class, 'user']);
    Route::get('/users/{user}', [UserController::class, 'show']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('/admin')->group(function (): void {
    Route::get('/users', [AdminController::class, 'users']);
});

Route::middleware('auth:sanctum')->post('/offline-sync', [OfflineSyncController::class, 'sync']);
Route::middleware('auth:sanctum')->get('/daily-summary', [DailySummaryController::class, 'show']);
Route::middleware('auth:sanctum')->post('/daily-summary', [DailySummaryController::class, 'store']);
Route::middleware('auth:sanctum')->put('/daily-summary', [DailySummaryController::class, 'store']);
Route::middleware('auth:sanctum')->put(
    '/activities/{activity}/reminder',
    [ActivityReminderController::class, 'update']
);

