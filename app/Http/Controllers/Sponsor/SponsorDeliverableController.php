<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sponsor\GetSponsorDeliverablesRequest;
use App\Services\Sponsor\SponsorDeliverableService;
use Illuminate\Support\Facades\Auth;

class SponsorDeliverableController extends Controller
{
    protected SponsorDeliverableService $deliverableService;

    public function __construct(SponsorDeliverableService $deliverableService)
    {
        $this->deliverableService = $deliverableService;
    }

    public function index(GetSponsorDeliverablesRequest $request)
    {
        $user = Auth::user();

        // dd($user);
        // $sponsor = $user->sponsor;
        
        // dd($sponsor);

        return $this->deliverableService->getDashboardDeliverables($user, $request->validated());
    }
}