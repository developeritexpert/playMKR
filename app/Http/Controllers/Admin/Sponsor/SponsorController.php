<?php

namespace App\Http\Controllers\Admin\Sponsor;

use App\Http\Controllers\Controller;
use App\Http\Requests\MailRequest\RejectSponsorRequest;
use App\Http\Requests\Sponsor\SponsorApplicationRequest;
use App\Services\Admin\Sponsor\SponsorService;
use App\Http\Requests\MailRequest\ApproveIdRequest;
use App\Http\Requests\Sponsor\StoreSponsorRequest;
use App\Http\Requests\Sponsor\UpdateSponsorRequest;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    protected SponsorService $sponsorService;

    public function __construct(SponsorService $sponsorService)
    {
        $this->sponsorService = $sponsorService;
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        return $this->sponsorService->getAll($perPage);
    }

    public function store(StoreSponsorRequest $request)
    {
        return $this->sponsorService->create($request->validated());
    }

    public function show($id)
    {
        return $this->sponsorService->getById($id);
    }

    public function update(UpdateSponsorRequest $request, $id)
    {
        return $this->sponsorService->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->sponsorService->delete($id);
    }

    public function sponsorRequestApplication(SponsorApplicationRequest $request)
    {
        return $this->sponsorService->sponserRequest($request->validated());
    }

    public function getSponsorRequestApplication(Request $request)
    {
        $perPage = $request->query('limit', $request->query('per_page', 10)); 
        $filters = $request->only(['search', 'status', 'from_date', 'to_date', 'date_sort']);

        return $this->sponsorService->getAllSponsorApplications($filters, $perPage);
    }

    public function approveSponser(ApproveIdRequest $request)
    {
        $id = $request->input('id');
        return $this->sponsorService->approveSponsor($id);
    }

    public function rejectSponser(RejectSponsorRequest $request)
    {
        $data = $request->validated();
        $id = $data['id'];
        return $this->sponsorService->rejectSponsor($id);
    }
}
