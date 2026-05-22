<?php

namespace App\Services\Deliverable;

use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Helpers\ApiResponse;
use App\Helpers\FileUploadHelper;
use App\Models\DeliverType;
use App\Repositories\Contracts\DeliverableRepositoryInterface;
use Exception;
use Illuminate\Support\Str;

class DeliverableService
{
    protected DeliverableRepositoryInterface $deliverableRepo;

    public function __construct(
        DeliverableRepositoryInterface $deliverableRepo
    ) {
        $this->deliverableRepo = $deliverableRepo;
    }

    public function getAll($perPage = 10)
    {
        try {
            $deliverables = $this->deliverableRepo->paginate($perPage);
            return ApiResponse::success(
                $deliverables,
                ApiMessages::DELIVERABLES_FETCHED
            );
        } catch (Exception $e) {

            return ApiResponse::error(
                ApiMessages::ERROR,
                StatusCodes::SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    public function getById(int $id)
    {
        try {
            $deliverable = $this->deliverableRepo->find($id);
            if (!$deliverable) {
                return ApiResponse::error(
                    ApiMessages::DELIVERABLE_NOT_FOUND,
                    StatusCodes::NOT_FOUND
                );
            }
            return ApiResponse::success(
                $deliverable,
                ApiMessages::DELIVERABLE_FETCHED
            );
        } catch (Exception $e) {
            return ApiResponse::error(
                ApiMessages::ERROR,
                StatusCodes::SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    public function create(array $data)
    {
        try {
            if (isset($data['deliver_type'])) {
                $deliverType = DeliverType::firstOrCreate(
                    ['name' => $data['deliver_type']]
                );
                $data['deliver_type_id'] = $deliverType->id;
                unset($data['deliver_type']);
            }
            if (isset($data['attachment'])) {
                $data['attachment'] = FileUploadHelper::upload($data['attachment'], 'deliverables');
            }
            $deliverable = $this->deliverableRepo->create($data);
            return ApiResponse::success(
                $deliverable,
                ApiMessages::DELIVERABLE_CREATED,
                StatusCodes::CREATED
            );
        } catch (Exception $e) {
            return ApiResponse::error(
                ApiMessages::ERROR,
                StatusCodes::SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    public function update(int $id, array $data)
    {
        try {
            $deliverable = $this->deliverableRepo->find($id);
            if (!$deliverable) {
                return ApiResponse::error(
                    ApiMessages::DELIVERABLE_NOT_FOUND,
                    StatusCodes::NOT_FOUND
                );
            }
            if (isset($data['deliver_type'])) {
                $slug = Str::slug($data['deliver_type']);
                $deliverType = DeliverType::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $data['deliver_type']]
                );
                $data['deliver_type_id'] = $deliverType->id;
                unset($data['deliver_type']);
            }
            if (isset($data['attachment'])) {
                FileUploadHelper::delete(
                    $deliverable->attachment
                );
                $data['attachment'] = FileUploadHelper::upload(
                    $data['attachment'],
                    'deliverables'
                );
            }
            $updatedDeliverable = $this->deliverableRepo
                ->update($deliverable, $data);
            return ApiResponse::success(
                $updatedDeliverable,
                ApiMessages::DELIVERABLE_UPDATED
            );
        } catch (Exception $e) {
            return ApiResponse::error(
                ApiMessages::ERROR,
                StatusCodes::SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    public function delete(int $id)
    {
        try {
            $deliverable = $this->deliverableRepo->find($id);
            if (!$deliverable) {
                return ApiResponse::error(
                    ApiMessages::DELIVERABLE_NOT_FOUND,
                    StatusCodes::NOT_FOUND
                );
            }
            FileUploadHelper::delete(
                $deliverable->attachment
            );
            $this->deliverableRepo->delete($deliverable);
            return ApiResponse::success(
                null,
                ApiMessages::DELIVERABLE_DELETED
            );
        } catch (Exception $e) {
            return ApiResponse::error(
                ApiMessages::ERROR,
                StatusCodes::SERVER_ERROR,
                $e->getMessage()
            );
        }
    }
}
