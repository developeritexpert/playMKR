<?php

use App\Http\Controllers\Admin\Deal\DealController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DealType\DealTypeController;
use App\Http\Controllers\Admin\Deliverable\DeliverableController;
use App\Http\Controllers\Admin\Sponsor\SponsorController;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\DeliverType\DeliverTypeController;
use App\Http\Controllers\Admin\InternalTeam\InternalTeamController;
use App\Http\Controllers\Admin\Invoice\InvoiceController;
use App\Http\Controllers\Admin\Profile\SettingsController;
use App\Http\Controllers\Admin\Ticket\TicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sponsor\SponsorDeliverableController;

Route::get('/user', function (Request $request) {
        return $request->user();
})->middleware('auth:api');

//Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
//Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Route to become Sposner
Route::post('/sponsor-request', [SponsorController::class, 'sponsorRequestApplication']);

Route::middleware(['auth:api'])->group(function () {
        // Route for manage Sponsers
        Route::get('/sponsor/all', [SponsorController::class, 'index']);
        Route::post('sponsor/add', [SponsorController::class, 'store']);
        Route::get('sponsor/{id}', [SponsorController::class, 'show']);
        Route::put('update/sponsor/{id}', [SponsorController::class, 'update']);
        Route::delete('delete/sponsor/{id}', [SponsorController::class, 'destroy']);

        // Logout Route
        Route::post('/logout', [AuthController::class, 'logout']);
        // Logout Route
        Route::post('/logout', [AuthController::class, 'logout']);

        // Get All Deals
        Route::get('deal/all', [DealController::class, 'index']);
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
                Route::get('/all-sponsors-request', [SponsorController::class, 'getSponsorRequestApplication']);
                Route::post('/approve-sponsor', [SponsorController::class, 'approveSponser']);
                Route::post('/reject-sponsor', [SponsorController::class, 'rejectSponser']);

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

                // Tickets Routes
                Route::get('tickets/all', [TicketController::class, 'index']);
                Route::post('tickets/add', [TicketController::class, 'store']);
                Route::get('ticket/{id}', [TicketController::class, 'show']);
                Route::put('ticket/update/{id}', [TicketController::class, 'update']);
                Route::delete('ticket/{id}', [TicketController::class, 'destroy']);

                // Invoice Routes
                Route::get('invoice/all', [InvoiceController::class, 'index']);
                Route::post('invoice/add', [InvoiceController::class, 'store']);
                Route::get('invoice/{id}', [InvoiceController::class, 'show']);
                Route::put('invoice/update/{id}', [InvoiceController::class, 'update']);
                Route::delete('invoice/delete/{id}', [InvoiceController::class, 'destroy']);

                // Internal Team
                Route::get('internal-team/all', [InternalTeamController::class, 'index']);
                Route::post('internal-team/add', [InternalTeamController::class, 'store']);
                Route::get('internal-team/{id}', [InternalTeamController::class, 'show']);
                Route::put('internal-team/{id}', [InternalTeamController::class, 'update']);
                Route::delete('internal-team/{id}', [InternalTeamController::class, 'destroy']);
        });


        // Route for update Profile Information
        Route::get('settings', [SettingsController::class, 'show']);
        Route::put('settings/profile/update', [SettingsController::class, 'update']);
        Route::put('settings/password/update', [SettingsController::class, 'updatePassword']);
     
        Route::middleware(['auth:api', 'role:sponser'])->prefix('sponsor')->group(function () {
                Route::get('deliverables', [SponsorDeliverableController::class, 'index']);

                Route::get('deliverables/{id}', [SponsorDeliverableController::class, 'show']);
        });
        
});
