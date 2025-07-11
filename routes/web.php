<?php

use App\Http\Controllers\Dashboard\Web\MenuController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('penduduk', App\Http\Controllers\PendudukController::class)->middleware(['auth', 'verified']);

Route::resource('dashboard/web/menu', MenuController::class)->middleware(['auth', 'verified']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
