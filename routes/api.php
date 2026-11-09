
<?php

use App\Http\Controllers\Api\ActivityReminderController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AdminDashboardController;
use App\Http\Controllers\Api\AdminReportController;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\DailyReportController;
use App\Http\Controllers\Api\DailySummaryController;
use App\Http\Controllers\Api\OfflineSyncController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::middleware('throttle:6,1')->group(function (): void {
    Route::post('/register', [AuthenticationController::class, 'register']);
    Route::post('/login', [AuthenticationController::class, 'login']);
    Route::post('/admin/login', [AuthenticationController::class, 'adminLogin']);
});

// Authenticated User Routes
Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/user', [AuthenticationController::class, 'user']);
    Route::get('/users/{user}', [UserController::class, 'show']);

    // Offline Synchronization
    Route::post('/offline-sync', [OfflineSyncController::class, 'sync']);

    // Daily Summary
    Route::get('/daily-summary', [DailySummaryController::class, 'show']);
    Route::post('/daily-summary', [DailySummaryController::class, 'store']);
    Route::put('/daily-summary', [DailySummaryController::class, 'store']);

    // Daily Reports
    Route::get('/daily-reports', [DailyReportController::class, 'index']);
    Route::post('/daily-reports', [DailyReportController::class, 'store']);
    Route::get('/daily-reports/{report}', [DailyReportController::class, 'show']);

    // Activity Reminder
    Route::put(
        '/activities/{activity}/reminder',
        [ActivityReminderController::class, 'update']
    );
});

// Existing Admin Users Route
Route::middleware(['auth:sanctum', 'role:admin'])
    ->prefix('admin')
    ->group(function (): void {
        Route::get('/users', [AdminController::class, 'users']);
    });

// Admin Dashboard and Management Routes
Route::middleware(['auth:sanctum', 'admin'])
    ->prefix('admin')
    ->group(function (): void {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);

        // Users
        Route::get('/dashboard/users', [AdminDashboardController::class, 'users']);
        Route::get('/users/{user}', [AdminDashboardController::class, 'user']);

        // Groups
        Route::get('/groups', [AdminDashboardController::class, 'groups']);
        Route::get('/groups/{group}', [AdminDashboardController::class, 'group']);

        // Daily Report Management
        Route::get('/reports', [AdminReportController::class, 'index']);
        Route::get('/reports/{report}', [AdminReportController::class, 'show']);

        // Report Feedback
        Route::post(
            '/reports/{report}/feedback',
            [AdminReportController::class, 'feedback']
        );

        // Update Report Status
        Route::patch(
            '/reports/{report}/status',
            [AdminReportController::class, 'status']
        );
    });
