<?php

namespace App\Services\Sponsor;

use Exception;
use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Helpers\ApiResponse;
use App\Repositories\Contracts\SponsorDeliverableRepositoryInterface;

class SponsorDeliverableService
{
    protected SponsorDeliverableRepositoryInterface $sponsorDeliverableRepo;

    public function __construct(SponsorDeliverableRepositoryInterface $sponsorDeliverableRepo)
    {
        $this->sponsorDeliverableRepo = $sponsorDeliverableRepo;
    }

    public function getDashboardDeliverables(object $user, array $filters)
    {
        try {
            if (!$user->sponsor) {
                return ApiResponse::error(
                    "Sponsor profile not found for this user.",
                    StatusCodes::NOT_FOUND
                );
            }

            $sponsorId = $user->sponsor->id;
            
            $data = $this->sponsorDeliverableRepo->getDeliverablesWithStats($sponsorId, $filters);

            return ApiResponse::success(
                $data,
                ApiMessages::DELIVERABLES_FETCHED,
                StatusCodes::OK
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