<?php

use App\Http\Controllers\Dashboard\Sid\ResidentController;
use App\Http\Controllers\Dashboard\Web\MenuController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\ShareDashboardData;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public routes
Route::get('/', function () {
    return Inertia::render('Public/Welcome');
})->name('home');

// Authenticated and verified routes
Route::middleware(['auth', 'verified', ShareDashboardData::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboard main page
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard/Index');
    })->name('dashboard');

    // SID routes
    Route::prefix('dashboard/sid')->name('dashboard.sid.')->group(function () {
        Route::resource('resident', ResidentController::class);
    });

    // Dashboard Web routes
    Route::prefix('dashboard/web')->name('dashboard.web.')->group(function () {
        Route::resource('menu', MenuController::class);
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
