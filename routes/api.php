<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Sponser\SponserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

// Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Sponser Application Routes
Route::post('/sponser-request', [SponserController::class, 'sponserRequestApplication']);


Route::middleware(['auth:api'])->group(function () {

    Route::middleware(['role:admin'])->group(function () {

    Route::get('test', function () {
        return 'test';
    });
        // Sponser Routes
        Route::post('/approve-sponser', [SponserController::class, 'approveSponser']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});
