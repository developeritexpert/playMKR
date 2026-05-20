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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SponserService
{
    protected SponserRepositoryInterface $sponserRepo;
    protected UserRepositoryInterface $userRepo;

    public function __construct(SponserRepositoryInterface $sponserRepo, UserRepositoryInterface $userRepo)
    {
        $this->sponserRepo = $sponserRepo;
        $this->userRepo = $userRepo;
    }

    public function getAll($perPage = 10)
    {
        try {
            $sponsors = $this->sponserRepo->paginate($perPage);
            return ApiResponse::success($sponsors, ApiMessages::SPONSORS_FETCHED);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
    }

    public function getById(int $id)
    {
        try {
            $sponsor = $this->sponserRepo->find($id);

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
            $user = Auth::user();
            if ($user) {
                $data['user_id'] = $user->id;
            } else {
                return ApiResponse::error(
                    ApiMessages::UNAUTHORIZED,
                    StatusCodes::UNAUTHORIZED
                );
            }
            $sponsor = $this->sponserRepo->create($data);
            return ApiResponse::success($sponsor, ApiMessages::SPONSOR_CREATED, StatusCodes::CREATED);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
    }

    public function update(int $id, array $data)
    {
        try {
            $sponsor = $this->sponserRepo->find($id);

            if (!$sponsor) {
                return ApiResponse::error(ApiMessages::SPONSOR_NOT_FOUND, StatusCodes::NOT_FOUND);
            }

            $updatedSponsor = $this->sponserRepo->update($sponsor, $data);
            return ApiResponse::success($updatedSponsor, ApiMessages::SPONSOR_UPDATED);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $sponsor = $this->sponserRepo->find($id);

            if (!$sponsor) {
                return ApiResponse::error(ApiMessages::SPONSOR_NOT_FOUND, StatusCodes::NOT_FOUND);
            }
            $this->sponserRepo->delete($sponsor);
            return ApiResponse::success(null, ApiMessages::SPONSOR_DELETED);
        } catch (Exception $e) {
            return ApiResponse::error(ApiMessages::ERROR, StatusCodes::SERVER_ERROR, $e->getMessage());
        }
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
            $sponsorApplication = $this->sponserRepo->findApplicationById($id);
            if (!$sponsorApplication) {
                return ApiResponse::error(
                    ApiMessages::SPONSER_NOT_FOUND,
                    StatusCodes::NOT_FOUND
                );
            }

            $existingUser = User::where('email', $sponsorApplication->email)->first();
            if ($existingUser) {
                return ApiResponse::error(
                    ApiMessages::EMAIL_APPROVED,
                    StatusCodes::UNPROCESSABLE_ENTITY
                );
            }

            // Generate password
            $password = Str::random(10);

            // Create sponsor user
            $user = $this->userRepo->create([
                'name' => $sponsorApplication->name,
                'email' => $sponsorApplication->email,
                'password' => $password,
                'role_id' => 2,
            ]);

            $sponsor = $this->sponserRepo->create([
                'user_id'         => $user->id,
                'name'            => $sponsorApplication->name,
                'company_name'    => $sponsorApplication->company_name,
                'sponser_name'    => $sponsorApplication->name,
                'industry'        => $sponsorApplication->industry,
                'website'         => $sponsorApplication->website_url,
                'primary_contact' => $sponsorApplication->contact_number,
                'email'           => $sponsorApplication->email,
                'phone'           => $sponsorApplication->contact_number,
                'location'        => $sponsorApplication->address,
            ]);

            // Update sponsor application status
            $updatedApplication = $this->sponserRepo->update(
                $sponsorApplication,
                [
                    'status' => 'approved',
                    'user_id' => $user->id,
                ]
            );

            Mail::to($user->email)->send(new SponsorApprovedMail($sponsorApplication, $password));

            return ApiResponse::success(
                $updatedApplication,
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
            // $sponsor = $this->sponserRepo->find($id);
            $sponsorApplication = $this->sponserRepo->findApplicationById($id);

            if (!$sponsorApplication) {
                return ApiResponse::error(
                    ApiMessages::SPONSER_NOT_FOUND,
                    StatusCodes::NOT_FOUND
                );
            }

            $updatedSponsor = $this->sponserRepo->update(
                $sponsorApplication,
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
