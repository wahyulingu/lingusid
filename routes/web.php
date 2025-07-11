<?php

use App\Http\Controllers\Dashboard\Web\MenuController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public routes
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Authenticated and verified routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Penduduk routes
    Route::resource('penduduk', PendudukController::class);

    // Dashboard Web routes
    Route::prefix('dashboard/web')->name('dashboard.web.')->group(function () {
        Route::resource('menu', MenuController::class);
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';