<?php

namespace App\Http\Controllers\Sponser;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sponsor\RejectSponsorRequest;
use App\Http\Requests\Sponsor\SponserApplicationRequest;
use App\Services\Sponser\SponserService;
use App\Http\Requests\Sponsor\ApproveIdRequest;

class SponserController extends Controller
{
    protected SponserService $sponserService;

    public function __construct(SponserService $sponserService)
    {
        $this->sponserService = $sponserService;
    }

    public function sponserRequestApplication(SponserApplicationRequest $request)
    {
        return $this->sponserService->sponserRequest($request->validated());
    }

    public function getSponserRequestApplication()
    {
        return $this->sponserService->getAllSponserApplications();
    }

    public function approveSponser(ApproveIdRequest $request)
    {
        $id = $request->input('id');
        return $this->sponserService->approveSponsor($id);
    }

    public function rejectSponser(RejectSponsorRequest $request)
    {
        $data = $request->validated();
        $id = $data['id'];
        return $this->sponserService->rejectSponsor($id);
    }
}
