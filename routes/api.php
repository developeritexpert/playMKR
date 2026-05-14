<?php

use App\Http\Controllers\Api\DealController;
use App\Http\Controllers\Api\SponsorController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::prefix('sponsors')->group(function () {
        Route::get('/all', [SponsorController::class, 'index']);
        Route::post('/add', [SponsorController::class, 'store']);
        Route::get('/{id}', [SponsorController::class, 'show']);
        Route::put('/{id}', [SponsorController::class, 'update']);
        Route::delete('/{id}', [SponsorController::class, 'destroy']);
    });

    Route::prefix('deals')->group(function () {
        Route::get('/all', [DealController::class, 'index']);
        Route::post('/add', [DealController::class, 'store']);
        Route::get('/{id}', [DealController::class, 'show']);
        Route::put('/{id}', [DealController::class, 'update']);
        Route::delete('/{id}', [DealController::class, 'destroy']);
    });

});