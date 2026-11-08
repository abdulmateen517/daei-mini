<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Daei Mini — User Productivity Panel Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('pages.user.dashboard');
})->name('home');

Route::get('/dashboard', function () {
    return view('pages.user.dashboard');
})->name('dashboard');

Route::get('/timetable', function () {
    return view('pages.user.timetable');
})->name('timetable');

Route::get('/prayers', function () {
    return view('pages.user.prayers');
})->name('prayers');

Route::get('/habits', function () {
    return view('pages.user.habits');
})->name('habits');

Route::get('/goals', function () {
    return view('pages.user.goals');
})->name('goals');

Route::get('/exercise', function () {
    return view('pages.user.exercise');
})->name('exercise');

Route::get('/quran-tafseer', function () {
    return view('pages.user.quran-tafseer');
})->name('quran-tafseer');

Route::get('/reading', function () {
    return view('pages.user.reading');
})->name('reading');

Route::get('/journal', function () {
    return view('pages.user.journal');
})->name('journal');

Route::get('/self-assessment', function () {
    return view('pages.user.self-assessment');
})->name('self-assessment');

Route::get('/daily-report', function () {
    return view('pages.user.daily-report');
})->name('daily-report');

Route::get('/feedback', function () {
    return view('pages.user.feedback');
})->name('feedback');

/*
|--------------------------------------------------------------------------
| Daei Mini — Admin & Mentor Supervisory Panel Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('pages.admin.dashboard');
    })->name('dashboard');

    Route::get('/users', function () {
        return view('pages.admin.users');
    })->name('users');

    Route::get('/groups', function () {
        return view('pages.admin.groups');
    })->name('groups');

    Route::get('/timetables', function () {
        return view('pages.admin.timetables');
    })->name('timetables');

    Route::get('/progress', function () {
        return view('pages.admin.progress');
    })->name('progress');

    Route::get('/reports', function () {
        return view('pages.admin.reports');
    })->name('reports');

    Route::get('/feedback', function () {
        return view('pages.admin.feedback');
    })->name('feedback');
});

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
