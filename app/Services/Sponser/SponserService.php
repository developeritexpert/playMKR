<?php

namespace App\Services\Sponser;

use Exception;
use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Helpers\ApiResponse;
use App\Repositories\Contracts\SponserRepositoryInterface;

class SponserService
{
    protected SponserRepositoryInterface $sponserRepo;

    public function __construct(SponserRepositoryInterface $sponserRepo)
    {
        $this->sponserRepo = $sponserRepo;
    }

    public function sponserRequest(array $data)
    {
        try{
            $addSponsorApplication = $this->sponserRepo->addSponserApplicationRequest($data);

            return ApiResponse::success(
                $addSponsorApplication,
                ApiMessages::SPONSER_REQUEST_SUCCESS,
                StatusCodes::CREATED
            );
        }
        catch(Exception $e){
            return ApiResponse::error(
                ApiMessages::ERROR,
                StatusCodes::SERVER_ERROR,
                $e->getMessage()
            );
        }
    }
}
