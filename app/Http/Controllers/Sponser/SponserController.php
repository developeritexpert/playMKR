<?php

namespace App\Http\Controllers\Sponser;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sponser\SponserApplicationRequest;
use App\Services\Sponser\SponserService;

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
}
