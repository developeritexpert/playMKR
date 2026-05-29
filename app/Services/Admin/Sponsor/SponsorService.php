<?php

namespace App\Services\Admin\Sponsor;

use Exception;
use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Helpers\ApiResponse;
use App\Repositories\Contracts\SponsorRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewSponsorRequestMail;
use App\Mail\SponsorApprovedMail;
use App\Mail\SponsorCredentialsMail;
use App\Mail\SponsorRejectedMail;
use App\Models\Sponsor;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class SponsorService
{
    protected SponsorRepositoryInterface $sponsorRepo;
    protected UserRepositoryInterface $userRepo;

    public function __construct(SponsorRepositoryInterface $sponsorRepo, UserRepositoryInterface $userRepo)
    {
        $this->sponsorRepo = $sponsorRepo;
        $this->userRepo = $userRepo;
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
        $existingUser = User::where('email', $data['email'])->first();
        if ($existingUser) {
            return ApiResponse::error(
                ApiMessages::EMAIL_ALREADY_EXISTS,
                StatusCodes::UNPROCESSABLE_ENTITY
            );
        }

        return DB::transaction(function () use ($data) {
            $password = Str::random(10);

            $user = $this->userRepo->create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => $password,
                'role_id'  => 3, 
            ]);

            $sponsorData = [
                'user_id'         => $user->id,
                'name'            => $data['name'],
                'company_name'    => $data['company_name'],
                'sponsor_name'    => $data['sponsor_name'],
                'industry'        => $data['industry'] ?? null,
                'website'         => $data['website'] ?? null,
                'primary_contact' => $data['primary_contact'] ?? null,
                'email'           => $data['email'],
                'phone'           => $data['phone'] ?? null,
                'location'        => $data['location'] ?? null,
            ];

            $sponsor = $this->sponsorRepo->create($sponsorData);


            Mail::to($user->email)->queue(new SponsorApprovedMail($sponsor, $password));

            return ApiResponse::success(
                $sponsor, 
                ApiMessages::SPONSOR_CREATED, 
                StatusCodes::CREATED
            );
        });

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

    public function sponserRequest(array $data)
    {
        try {
            $addSponsorApplication = $this->sponsorRepo->addSponserApplicationRequest($data);
            $adminEmail = config('mail.admin_email', 'manjeetsingh90692@gmail.com');
            // Mail::to($adminEmail)->send(new NewSponsorRequestMail($addSponsorApplication));
            Mail::to($adminEmail)->queue(new NewSponsorRequestMail($addSponsorApplication));
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

    public function getAllSponsorApplications(array $filters = [], $perPage = 10)
    {
        try {
            $applications = $this->sponsorRepo->paginateApplications($filters, $perPage);
            
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
            $sponsorApplication = $this->sponsorRepo->findApplicationById($id);
            
            if (!$sponsorApplication) {
                return ApiResponse::error(
                    ApiMessages::SPONSER_NOT_FOUND,
                    StatusCodes::NOT_FOUND
                );
            }

            if ($sponsorApplication->status === 'approved') {
                return ApiResponse::error(
                    ApiMessages::EMAIL_APPROVED,
                    StatusCodes::BAD_REQUEST
                );
            }

            $password = Str::random(10);
            $user = $this->userRepo->findByEmail($sponsorApplication->email);
            if ($user) {
                $this->userRepo->updateByEmail($user->email, [
                    'password' => $password,
                    'role_id'  => 3,
                ]);
            } else {
                $user = $this->userRepo->create([
                    'name'     => $sponsorApplication->name,
                    'email'    => $sponsorApplication->email,
                    'password' => $password,
                    'role_id'  => 3,
                ]);
            }

            $sponsor = Sponsor::where('user_id', $user->id)->first();
            
            if (!$sponsor) {
                $sponsor = $this->sponsorRepo->create([
                    'user_id'         => $user->id,
                    'name'            => $sponsorApplication->name,
                    'company_name'    => $sponsorApplication->company_name,
                    'sponsor_name'    => $sponsorApplication->name,
                    'industry'        => $sponsorApplication->industry,
                    'website'         => $sponsorApplication->website_url,
                    'primary_contact' => $sponsorApplication->contact_number,
                    'email'           => $sponsorApplication->email,
                    'phone'           => $sponsorApplication->contact_number,
                    'location'        => $sponsorApplication->address,
                ]);
            }

            $updatedApplication = $this->sponsorRepo->update(
                $sponsorApplication,
                ['status' => 'approved']
            );
            Mail::to($user->email)->queue(new SponsorApprovedMail($sponsorApplication, $password));

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
            // $sponsor = $this->sponsorRepo->find($id);
            $sponsorApplication = $this->sponsorRepo->findApplicationById($id);

            if (!$sponsorApplication) {
                return ApiResponse::error(
                    ApiMessages::SPONSER_NOT_FOUND,
                    StatusCodes::NOT_FOUND
                );
            }

            if ($sponsorApplication->status === 'approved') {
                return ApiResponse::error(
                    ApiMessages::CANNOT_BE_REJECTED,
                    StatusCodes::BAD_REQUEST
                );
            }

            $updatedSponsor = $this->sponsorRepo->update(
                $sponsorApplication,
                ['status' => 'rejected']
            );
            // Mail::to($updatedSponsor->email)->send(new SponsorRejectedMail($updatedSponsor));
            Mail::to($updatedSponsor->email)->queue(new SponsorRejectedMail($updatedSponsor));
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
