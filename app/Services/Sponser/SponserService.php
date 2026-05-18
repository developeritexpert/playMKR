<?php

namespace App\Services\Sponser;

use Exception;
use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Helpers\ApiResponse;
use App\Repositories\Contracts\SponserRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewSponsorRequestMail;
use App\Mail\SponsorApprovedMail;
use App\Mail\SponsorRejectedMail;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class SponserService
{
    protected SponserRepositoryInterface $sponserRepo;
    protected UserRepositoryInterface $userRepo;

    public function __construct(SponserRepositoryInterface $sponserRepo , UserRepositoryInterface $userRepo)
    {
        $this->sponserRepo = $sponserRepo;
        $this->userRepo = $userRepo;
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

            $existingUser = User::where('email', $sponsor->email)->first();
            if ($existingUser) {
                return ApiResponse::error(
                    ApiMessages::EMAIL_APPROVED,
                    StatusCodes::UNPROCESSABLE_ENTITY
                );
            }

            // Generate password
            $password = Str::random(10);

            // Create sponser user
            $user = $this->userRepo->create([
                'name' => $sponsor->name,
                'email' => $sponsor->email,
                'password' => $password,
                'role_id' => 2,
            ]);

            $updatedSponsor = $this->sponserRepo->update($sponsor, 
            [
                'status' => 'approved',
                 'user_id' => $user->id,
            ]);

            Mail::to($user->email)->send(new SponsorApprovedMail($sponsor, $password));
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
            Mail::to($updatedSponsor->email)->send(new SponsorRejectedMail($updatedSponsor));
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
