<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sponsor\StoreSponsorRequest;
use App\Http\Requests\Sponsor\UpdateSponsorRequest;
use App\Services\SponsorService;
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
        // return $this->sponsorService->getAll(); 
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
}