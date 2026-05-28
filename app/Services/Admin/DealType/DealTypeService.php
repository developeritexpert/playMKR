<?php

namespace App\Services\Admin\DealType;

use App\Repositories\Contracts\DealTypeRepositoryInterface;
use App\Helpers\ApiResponse;
use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use Illuminate\Support\Str;
use Exception;

class DealTypeService
{
    protected DealTypeRepositoryInterface $dealTypeRepo;

    public function __construct(DealTypeRepositoryInterface $dealTypeRepo)
    {
        $this->dealTypeRepo = $dealTypeRepo;
    }

    public function getAll($perPage = 10){
        try {
            $types = $this->dealTypeRepo->paginate($perPage);
            return ApiResponse::success($types, ApiMessages::DEAL_TYPES_FETCHED);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
    }

    public function getById(int $id)
    {
        try {
            $type = $this->dealTypeRepo->find($id);
            if (!$type) return ApiResponse::error(ApiMessages::DEAL_TYPE_NOT_FOUND, StatusCodes::NOT_FOUND);

            return ApiResponse::success($type, ApiMessages::DEAL_TYPE_FETCHED);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
    }

    public function create(array $data)
    {
        try {
            $data['slug'] = Str::slug($data['name']);

            $type = $this->dealTypeRepo->create($data);
            return ApiResponse::success($type, ApiMessages::DEAL_TYPE_CREATED, StatusCodes::CREATED);
        } catch (\Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
    }

    public function update(int $id, array $data)
    {
        try {
            $type = $this->dealTypeRepo->find($id);
            if (!$type) {
                return ApiResponse::error(ApiMessages::DEAL_TYPE_NOT_FOUND, StatusCodes::NOT_FOUND);
            }
            $data['slug'] = Str::slug($data['name']);
            $updated = $this->dealTypeRepo->update($type, $data);
            return ApiResponse::success($updated, ApiMessages::DEAL_TYPE_UPDATED);
        } catch (\Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $type = $this->dealTypeRepo->find($id);
            if (!$type) return ApiResponse::error(ApiMessages::DEAL_TYPE_NOT_FOUND, StatusCodes::NOT_FOUND);

            $this->dealTypeRepo->delete($type);
            return ApiResponse::success(null, ApiMessages::DEAL_TYPE_DELETED);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
    }
}
