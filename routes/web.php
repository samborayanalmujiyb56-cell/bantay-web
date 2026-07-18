<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    Route::get('/farmers', fn () => view('stub', ['title' => 'Farmers & Farms', 'phase' => 'Phase 6']))->name('farmers.index');
    Route::get('/reports', fn () => view('stub', ['title' => 'Disease Reports', 'phase' => 'Phase 6']))->name('reports.index');
    Route::get('/surveillance', fn () => view('stub', ['title' => 'Surveillance Map', 'phase' => 'Phase 7']))->name('surveillance.map');
    Route::get('/advisories', fn () => view('stub', ['title' => 'Advisories', 'phase' => 'Phase 7']))->name('advisories.index');
    Route::get('/analytics', fn () => view('stub', ['title' => 'Analytics', 'phase' => 'Phase 9']))->name('analytics.index');
});

Route::get('/', fn () => redirect()->route('login'));