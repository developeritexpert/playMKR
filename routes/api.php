<?php

use App\Http\Controllers\Deal\DealController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DealType\DealTypeController;
use App\Http\Controllers\Deliverable\DeliverableController;
use App\Http\Controllers\Sponser\SponserController;
use Illuminate\Http\Request;
use App\Http\Controllers\DeliverType\DeliverTypeController;
use App\Http\Controllers\InternalTeam\InternalTeamController;
use App\Http\Controllers\Profile\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

//Auth Routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    // Route to become Sposner
    Route::post('/sponser-request', [SponserController::class, 'sponserRequestApplication']);

    Route::middleware(['auth:api'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        // Route for manage Sponsers
        Route::get('/sponsor/all', [SponserController::class, 'index']);
        Route::post('sponsor/add', [SponserController::class, 'store']);
        Route::get('sponsor/{id}', [SponserController::class, 'show']);
        Route::put('update/sponsor/{id}', [SponserController::class, 'update']);
        Route::delete('delete/sponsor/{id}', [SponserController::class, 'destroy']);

        // Get All Deals
        Route::get('deal/all', [DealController::class, 'index']);

    Route::middleware(['role:admin'])->group(function () {
        // Deal Add and Manged by Admin
        Route::post('deal/add', [DealController::class, 'store']);
        Route::get('deal/{id}', [DealController::class, 'show']);
        Route::put('update/deal/{id}', [DealController::class, 'update']);
        Route::delete('delete/deal/{id}', [DealController::class, 'destroy']);

        // Route to manage Deal_type
        Route::get('deal-type/all', [DealTypeController::class, 'index']);
        Route::post('deal-type/add', [DealTypeController::class, 'store']);
        Route::get('deal-type/{id}', [DealTypeController::class, 'show']);
        Route::put('deal-type/update/{id}', [DealTypeController::class, 'update']);
        Route::delete('deal-type/delete/{id}', [DealTypeController::class, 'destroy']);

        // Sponser Requests, Approve and Reject Routes
        Route::get('/all-sponsers-request', [SponserController::class, 'getSponserRequestApplication']);
        Route::post('/approve-sponser', [SponserController::class, 'approveSponser']);
        Route::post('/reject-sponser', [SponserController::class, 'rejectSponser']);

        // Routes for Deliverable
        Route::get('/deliverables/all', [DeliverableController::class, 'index']);
        Route::post('deliverables/add', [DeliverableController::class, 'store']);
        Route::get('deliverables/{id}', [DeliverableController::class, 'show']);
        Route::put('deliverables/update/{id}', [DeliverableController::class, 'update']);
        Route::delete('deliverables/{id}', [DeliverableController::class, 'destroy']);

        // Manage delevery type like : capaign , Post and Video
        Route::get('deliver-type/all', [DeliverTypeController::class, 'index']);
        Route::post('deliver-type/add', [DeliverTypeController::class, 'store']);
        Route::get('deliver-type/{id}', [DeliverTypeController::class, 'show']);
        Route::put('deliver-type/update/{id}', [DeliverTypeController::class, 'update']);
        Route::delete('deliver-type/delete/{id}', [DeliverTypeController::class, 'destroy']);
        });

        // Route for update Profile Information
        Route::get('settings', [SettingsController::class, 'show']);
        Route::put('settings/profile/update', [SettingsController::class, 'update']);
        Route::put('settings/passwordupdate', [SettingsController::class, 'updatePassword']);

        // Internal Team
        Route::get('internal-team/all',[InternalTeamController::class, 'index']);
        Route::post('internal-team/add', [InternalTeamController::class, 'store']);
        Route::get('internal-team/{id}',[InternalTeamController::class, 'show']);
        Route::put('internal-team/{id}',[InternalTeamController::class, 'update']);
        Route::delete('internal-team/{id}',[InternalTeamController::class, 'destroy']);
    });
