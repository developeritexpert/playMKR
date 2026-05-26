<?php

namespace App\Http\Controllers\DeliverType;

use App\Http\Controllers\Controller;
use App\Services\DeliverType\DeliverTypeService;
use App\Http\Requests\DeliverType\StoreDeliverTypeRequest;
use App\Http\Requests\DeliverType\UpdateDeliverTypeRequest;

use App\Helpers\ApiResponse;
use App\Constants\ApiMessages;
use App\Constants\StatusCodes;

class DeliverTypeController extends Controller
{
    protected $deliverTypeService;

    public function __construct(DeliverTypeService $deliverTypeService)
    {
        $this->deliverTypeService = $deliverTypeService;
    }

    public function index()
    {
        $data = $this->deliverTypeService->getAll();

        return ApiResponse::success(
            $data,
            ApiMessages::DELIVER_TYPE_LIST,
            StatusCodes::OK
        );
    }

    public function store(StoreDeliverTypeRequest $request)
    {
        $data = $this->deliverTypeService->create($request->validated());

        return ApiResponse::success(
            $data,
            ApiMessages::DELIVER_TYPE_CREATED,
            StatusCodes::CREATED
        );
    }

    public function update(UpdateDeliverTypeRequest $request, int $id)
    {
        $data = $this->deliverTypeService->update($id, $request->validated());

        if (!$data) {
            return ApiResponse::error(
                ApiMessages::DELIVER_TYPE_NOT_FOUND,
                StatusCodes::NOT_FOUND
            );
        }

        return ApiResponse::success(
            $data,
            ApiMessages::DELIVER_TYPE_UPDATED,
            StatusCodes::OK
        );
    }

    public function destroy(int $id)
    {
        $deliverType = $this->deliverTypeService->findById($id);

        if (!$deliverType) {
            return ApiResponse::error(
                ApiMessages::DELIVER_TYPE_NOT_FOUND,
                StatusCodes::NOT_FOUND
            );
        }

        if ($deliverType->deliverables()->count() > 0) {

            return ApiResponse::error(
                'Cannot delete. Type already used in deliverables.',
                StatusCodes::BAD_REQUEST
            );
        }

        $this->deliverTypeService->delete($id);

        return ApiResponse::success(
            [],
            ApiMessages::DELIVER_TYPE_DELETED,
            StatusCodes::OK
        );
    }
}
