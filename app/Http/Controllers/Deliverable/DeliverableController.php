<?php

namespace App\Http\Controllers\Deliverable;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deliverable\StoreDeliverableRequest;
use App\Http\Requests\Deliverable\UpdateDeliverableRequest;
use App\Services\Deliverable\DeliverableService;
use Illuminate\Http\Request;

class DeliverableController extends Controller
{
    protected DeliverableService $deliverableService;

    public function __construct(DeliverableService $deliverableService)
    {
        $this->deliverableService = $deliverableService;
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        return $this->deliverableService->getAll($perPage);
    }

    public function store(StoreDeliverableRequest $request)
    {
        return $this->deliverableService->create($request->validated());
    }

    public function show(int $id)
    {
        return $this->deliverableService->getById($id);
    }

    public function update(UpdateDeliverableRequest $request, int $id)
    {
        return $this->deliverableService->update($id, $request->validated());
    }


    public function destroy(int $id)
    {
        return $this->deliverableService
            ->delete($id);
    }
}
