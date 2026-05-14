<?php

namespace App\Services;

use App\Repositories\Contracts\SponsorRepositoryInterface;
use App\Helpers\ApiResponse;
use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use Exception;

class SponsorService
{
    protected SponsorRepositoryInterface $sponsorRepo;

    public function __construct(SponsorRepositoryInterface $sponsorRepo)
    {
        $this->sponsorRepo = $sponsorRepo;
    }

    public function getAll($perPage = 10)
    {
        try {
            
            $sponsors = $this->sponsorRepo->paginate($perPage);
            return ApiResponse::success($sponsors, ApiMessages::SPONSORS_FETCHED);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
    }

    public function getById(int $id)
    {
        try {
            $sponsor = $this->sponsorRepo->find($id);

            if (!$sponsor) {
                return ApiResponse::error(ApiMessages::SPONSOR_NOT_FOUND, StatusCodes::NOT_FOUND);
            }

            return ApiResponse::success($sponsor, ApiMessages::SPONSOR_FETCHED);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
    }

    public function create(array $data)
    {
        try {
            $sponsor = $this->sponsorRepo->create($data);
            return ApiResponse::success($sponsor, ApiMessages::SPONSOR_CREATED, StatusCodes::CREATED);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
    }

    public function update(int $id, array $data)
    {
        try {
            $sponsor = $this->sponsorRepo->find($id);

            if (!$sponsor) {
                return ApiResponse::error(ApiMessages::SPONSOR_NOT_FOUND, StatusCodes::NOT_FOUND);
            }

            $updatedSponsor = $this->sponsorRepo->update($sponsor, $data);
            return ApiResponse::success($updatedSponsor, ApiMessages::SPONSOR_UPDATED);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $sponsor = $this->sponsorRepo->find($id);

            if (!$sponsor) {
                return ApiResponse::error(ApiMessages::SPONSOR_NOT_FOUND, StatusCodes::NOT_FOUND);
            }

            $this->sponsorRepo->delete($sponsor);
            return ApiResponse::success(null, ApiMessages::SPONSOR_DELETED);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
    }
}