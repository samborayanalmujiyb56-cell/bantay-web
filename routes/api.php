<?php

use App\Modules\Auth\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Any authenticated user (admin or farmer)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (\Illuminate\Http\Request $request) {
        return $request->user();
    });
});

// Admin/MAO-only routes
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/admin/ping', function () {
        return response()->json(['message' => 'You are an admin.']);
    });
});

// Farmer-only routes

Route::middleware(['auth:sanctum', 'farmer'])->group(function () {
    Route::get('/farmer/ping', function () {
        return response()->json(['message' => 'You are a farmer.']);
    });

    Route::get('/farms', [\App\Modules\FarmManagement\Controllers\FarmController::class, 'index']);
    Route::post('/farms', [\App\Modules\FarmManagement\Controllers\FarmController::class, 'store']);
    Route::put('/farms/{farm}', [\App\Modules\FarmManagement\Controllers\FarmController::class, 'update']);
    Route::post('/farms/{farm}/production', [\App\Modules\FarmManagement\Controllers\FarmController::class, 'addProduction']);


        
    });
