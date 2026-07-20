<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
Route::get('/dashboard', [App\Http\Controllers\AnalyticsController::class, 'index'])->name('dashboard');

    Route::get('/farmers', fn () => view('stub', ['title' => 'Farmers & Farms', 'phase' => 'Phase 6']))->name('farmers.index');
   Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
Route::post('/reports/{report}/validate', [App\Http\Controllers\ReportController::class, 'validateReport'])->name('reports.validate');
Route::post('/reports/{report}/reject', [App\Http\Controllers\ReportController::class, 'reject'])->name('reports.reject');
    Route::get('/surveillance', [App\Http\Controllers\SurveillanceController::class, 'map'])->name('surveillance.map');
    Route::get('/advisories', fn () => view('stub', ['title' => 'Advisories', 'phase' => 'Phase 7']))->name('advisories.index');
    Route::get('/analytics', fn () => view('stub', ['title' => 'Analytics', 'phase' => 'Phase 9']))->name('analytics.index');
});

Route::get('/', fn () => redirect()->route('login'));