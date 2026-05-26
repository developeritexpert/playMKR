<?php

namespace App\Services\InternalTeam;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use App\Helpers\ApiResponse;
use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use Illuminate\Support\Facades\Mail;
use App\Mail\InternalTeamCredentialsMail;
use App\Repositories\Contracts\InternalTeamRepositoryInterface;

class InternalTeamService
{
    protected InternalTeamRepositoryInterface $internalTeamRepo;

    public function __construct(InternalTeamRepositoryInterface $internalTeamRepo)
    {
        $this->internalTeamRepo = $internalTeamRepo;
    }

    public function getAll($perPage = 10)
    {
        try {
            $users = $this->internalTeamRepo->paginate($perPage);
            return ApiResponse::success(
                $users,
                ApiMessages::INTERNAL_TEAM_FETCHED
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
            $user = $this->internalTeamRepo->find($id);
            if (!$user) {
                return ApiResponse::error(
                    ApiMessages::INTERNAL_TEAM_NOT_FOUND,
                    StatusCodes::NOT_FOUND
                );
            }
            return ApiResponse::success($user);
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
            $existingUser = User::where('email', $data['email'])->first();
            if ($existingUser) {
                return ApiResponse::error(
                    ApiMessages::INTERNAL_TEAM_EMAIL_EXISTS,
                    StatusCodes::UNPROCESSABLE_ENTITY
                );
            }

            // Create random Password For internal Team Member
            $password = Str::random(10);

            // Create Internal Team User
            $user = $this->internalTeamRepo->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $password,
                'role_id' => 2,
            ]);
            Mail::to($user->email)->send(new InternalTeamCredentialsMail($user, $password));
            return ApiResponse::success(
                $user,
                ApiMessages::INTERNAL_TEAM_CREATED,
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
            $user = $this->internalTeamRepo->find($id);
            if (!$user) {
                return ApiResponse::error(
                    ApiMessages::INTERNAL_TEAM_NOT_FOUND,
                    StatusCodes::NOT_FOUND
                );
            }

            $updatedUser = $this->internalTeamRepo
                ->update($user, $data);
            return ApiResponse::success(
                $updatedUser,
                ApiMessages::INTERNAL_TEAM_UPDATED
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
            $user = $this->internalTeamRepo->find($id);
            if (!$user) {
                return ApiResponse::error(
                    ApiMessages::INTERNAL_TEAM_NOT_FOUND,
                    StatusCodes::NOT_FOUND
                );
            }

            $this->internalTeamRepo->delete($user);
            return ApiResponse::success(
                null,
                ApiMessages::INTERNAL_TEAM_DELETED
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
