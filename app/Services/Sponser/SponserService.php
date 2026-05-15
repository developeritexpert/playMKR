<?php

namespace App\Services\Sponser;

use Exception;
use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Helpers\ApiResponse;
use App\Repositories\Contracts\SponserRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewSponsorRequestMail;

class SponserService
{
    protected SponserRepositoryInterface $sponserRepo;

    public function __construct(SponserRepositoryInterface $sponserRepo)
    {
        $this->sponserRepo = $sponserRepo;
    }

    public function sponserRequest(array $data)
    {
        try {
            $addSponsorApplication = $this->sponserRepo->addSponserApplicationRequest($data);
            $adminEmail = config('mail.admin_email', 'manjeetsingh90692@gmail.com');
            Mail::to($adminEmail)->send(new NewSponsorRequestMail($addSponsorApplication));

            return ApiResponse::success(
                $addSponsorApplication,
                ApiMessages::SPONSER_REQUEST_SUCCESS,
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

    public function getAllSponserApplications()
    {
        try {
            $applications = $this->sponserRepo->getAllSponserApplications();
            return ApiResponse::success(
                $applications,
                ApiMessages::SPONSER_LIST_SUCCESS,
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

    public function approveSponsor(int $id)
    {
        try {
            $sponsor = $this->sponserRepo->find($id);
            if (!$sponsor) {
                return ApiResponse::error(
                    ApiMessages::SPONSOR_NOT_FOUND,
                    StatusCodes::NOT_FOUND
                );
            }

            $updatedSponsor = $this->sponserRepo->update($sponsor, ['status' => 'approved']);
            return ApiResponse::success(
                $updatedSponsor,
                ApiMessages::SPONSER_APPROVED,
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

    public function rejectSponsor(int $id)
    {
        try {
            $sponsor = $this->sponserRepo->find($id);

            if (!$sponsor) {
                return ApiResponse::error(
                    ApiMessages::SPONSER_NOT_FOUND,
                    StatusCodes::NOT_FOUND
                );
            }

            $updatedSponsor = $this->sponserRepo->update(
                $sponsor,
                ['status' => 'rejected']
            );
            return ApiResponse::success(
                $updatedSponsor,
                ApiMessages::SPONSER_REJECTED,
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
