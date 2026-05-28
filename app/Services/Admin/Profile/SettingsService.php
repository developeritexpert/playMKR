<?php

namespace App\Services\Admin\Profile;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Helpers\ApiResponse;
use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use Illuminate\Support\Facades\Hash;

class SettingsService
{
    protected UserRepositoryInterface $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function getProfile($user)
    {
        return ApiResponse::success($user, ApiMessages::SUCCESS, StatusCodes::OK);
    }

    public function updateProfile($user, array $data)
    {
        if (isset($data['avatar'])) {
            $path = $data['avatar']->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $updatedUser = $this->userRepo->updateByEmail($user->email, $data);

        // Update related sponsor table if user is a sponsor
        if ($user->role_id == 3) {
            $sponsorData = [];
            if (isset($data['name'])) {
                $sponsorData['name'] = $data['name'];
            }
            if (isset($data['email'])) {
                $sponsorData['email'] = $data['email'];
            }
            if (!empty($sponsorData)) {
                $user->sponsor()->updateOrCreate([], $sponsorData);
            }
        }
        // Convert avatar to full URL
        // if ($updatedUser && $updatedUser->avatar) {
        //     $updatedUser->avatar = asset('storage/' . $updatedUser->avatar);
        // }

        return ApiResponse::success($updatedUser, ApiMessages::PROFILE_UPDATED, StatusCodes::OK);
    }

    public function updatePassword($user, array $data)
    {
        if (!Hash::check($data['current_password'], $user->password)) {
            return ApiResponse::error(ApiMessages::INVALID_CURRENT_PASSWORD, StatusCodes::BAD_REQUEST);
        }

        $this->userRepo->updateByEmail($user->email, [
            'password' => Hash::make($data['new_password'])
        ]);

        return ApiResponse::success([], ApiMessages::PASSWORD_UPDATED, StatusCodes::OK);
    }
}
