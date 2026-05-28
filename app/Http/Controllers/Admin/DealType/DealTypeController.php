<?php

namespace App\Http\Controllers\Admin\DealType;

use App\Http\Controllers\Controller;
use App\Http\Requests\DealType\StoreDealTypeRequest;
use App\Http\Requests\DealType\UpdateDealTypeRequest;
use App\Services\Admin\DealType\DealTypeService;
use Illuminate\Http\Request;

class DealTypeController extends Controller
{
    protected DealTypeService $dealTypeService;

    public function __construct(DealTypeService $dealTypeService)
    {
        $this->dealTypeService = $dealTypeService;
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        return $this->dealTypeService->getAll($perPage);
    }

    public function store(StoreDealTypeRequest $request)
    {
        return $this->dealTypeService->create($request->validated());
    }

    public function show($id)
    {
        return $this->dealTypeService->getById($id);
    }

    public function update(UpdateDealTypeRequest $request, $id)
    {
        return $this->dealTypeService->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->dealTypeService->delete($id);
    }
}
