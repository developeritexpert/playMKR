<?php

namespace App\Http\Controllers\Admin\Deal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deal\StoreDealRequest;
use App\Http\Requests\Deal\UpdateDealRequest;
use App\Services\Admin\Deal\DealService;
use Illuminate\Http\Request;

class DealController extends Controller
{
    protected DealService $dealService;

    public function __construct(DealService $dealService)
    {
        $this->dealService = $dealService;
    }

    public function index(Request $request)
    {
        $perPage = $request->query('limit', $request->query('per_page', 10));
        $filters = $request->only(['search', 'status']); // Matches Figma
        
        return $this->dealService->getAll($filters, $perPage);
    }

    public function store(StoreDealRequest $request)
    {
        return $this->dealService->create($request->validated());
    }

    public function show($id)
    {
        return $this->dealService->getById($id);
    }

    public function update(UpdateDealRequest $request, $id)
    {
        return $this->dealService->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->dealService->delete($id);
    }
}
