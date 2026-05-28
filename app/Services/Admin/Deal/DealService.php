<?php

namespace App\Services\Admin\Deal;

use App\Repositories\Contracts\DealRepositoryInterface;
use App\Helpers\ApiResponse;
use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Models\DealType;
use Illuminate\Support\Str;
use Exception;

class DealService
{
    protected DealRepositoryInterface $dealRepo;

    public function __construct(DealRepositoryInterface $dealRepo)
    {
        $this->dealRepo = $dealRepo;
    }

    public function getAll(array $filters = [], $perPage = 10)
    {
        try {
            $deals = $this->dealRepo->paginate($filters, $perPage);
            return ApiResponse::success($deals, ApiMessages::DEALS_FETCHED);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
    }

    public function getById(int $id)
    {
        try {
            $deal = $this->dealRepo->find($id);

            if (!$deal) {
                return ApiResponse::error(ApiMessages::DEAL_NOT_FOUND, StatusCodes::NOT_FOUND);
            }

            return ApiResponse::success($deal, ApiMessages::DEAL_FETCHED);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
    }

    public function create(array $data)
    {
        try {
            if (isset($data['deal_type'])) {
                $slug = Str::slug($data['deal_type']);

                $dealType = DealType::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $data['deal_type']]
                );

                $data['deal_type_id'] = $dealType->id;
                unset($data['deal_type']);
            }

            $deal = $this->dealRepo->create($data);
            return ApiResponse::success($deal, ApiMessages::DEAL_CREATED, StatusCodes::CREATED);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
    }

    public function update(int $id, array $data)
    {
        try {
            $deal = $this->dealRepo->find($id);
            if (!$deal) {
                return ApiResponse::error(ApiMessages::DEAL_NOT_FOUND, StatusCodes::NOT_FOUND);
            }

            if (isset($data['deal_type'])) {
                $slug = Str::slug($data['deal_type']);

                $dealType = DealType::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $data['deal_type']]
                );

                $data['deal_type_id'] = $dealType->id;
                unset($data['deal_type']);
            }

            $updatedDeal = $this->dealRepo->update($deal, $data);
            return ApiResponse::success($updatedDeal, ApiMessages::DEAL_UPDATED);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $deal = $this->dealRepo->find($id);

            if (!$deal) {
                return ApiResponse::error(ApiMessages::DEAL_NOT_FOUND, StatusCodes::NOT_FOUND);
            }

            $this->dealRepo->delete($deal);
            return ApiResponse::success(null, ApiMessages::DEAL_DELETED);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
    }
}
