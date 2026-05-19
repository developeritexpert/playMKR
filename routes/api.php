<?php

use App\Http\Controllers\Api\DealController;
use App\Http\Controllers\Api\SponsorController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Sponser\SponserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::post('/sponser-request', [SponserController::class, 'sponserRequestApplication']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/sponsor/all', [SponserController::class, 'index']);
    Route::post('sponsor/add', [SponserController::class, 'store']);
    Route::get('sponsor/{id}', [SponserController::class, 'show']);
    Route::put('update/sponsor/{id}', [SponserController::class, 'update']);
    Route::delete('delete/sponsor/{id}', [SponserController::class, 'destroy']);

    Route::get('deal/all', [DealController::class, 'index']);
    Route::post('deal/add', [DealController::class, 'store']);
    Route::get('deal/{id}', [DealController::class, 'show']);
    Route::put('update/deal/{id}', [DealController::class, 'update']);
    Route::delete('delete/deal/{id}', [DealController::class, 'destroy']);

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/all-sponsers-request', [SponserController::class, 'getSponserRequestApplication']);
        Route::post('/approve-sponser', [SponserController::class, 'approveSponser']);
        Route::post('/reject-sponser', [SponserController::class, 'rejectSponser']);
    });
    
});
