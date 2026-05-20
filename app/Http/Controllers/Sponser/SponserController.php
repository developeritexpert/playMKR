<?php

namespace App\Http\Controllers\Sponser;

use App\Http\Controllers\Controller;
use App\Http\Requests\MailRequest\RejectSponsorRequest;
use App\Http\Requests\Sponsor\SponserApplicationRequest;
use App\Services\Sponser\SponserService;
use App\Http\Requests\MailRequest\ApproveIdRequest;
use App\Http\Requests\Sponsor\StoreSponsorRequest;
use App\Http\Requests\Sponsor\UpdateSponsorRequest;
use Illuminate\Http\Request;

class SponserController extends Controller
{
    protected SponserService $sponserService;

    public function __construct(SponserService $sponserService)
    {
        $this->sponserService = $sponserService;
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        return $this->sponserService->getAll($perPage);
    }

    public function store(StoreSponsorRequest $request)
    {
        return $this->sponserService->create($request->validated());
    }

    public function show($id)
    {
        return $this->sponserService->getById($id);
    }

    public function update(UpdateSponsorRequest $request, $id)
    {
        return $this->sponserService->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->sponserService->delete($id);
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
