<?php

namespace App\Services\Auth;

use App\Repositories\Contracts\UserRepositoryInterface;
use Exception;
use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Helpers\ApiResponse;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthService
{
    protected UserRepositoryInterface $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(array $data)
    {
        try {
            if ($this->userRepo->findByEmail($data['email'])) {
                return ApiResponse::error(
                    ApiMessages::EMAIL_ALREADY_EXISTS,
                    StatusCodes::BAD_REQUEST
                );
            }

            $user = $this->userRepo->create($data);

            return ApiResponse::success(
                $user,
                ApiMessages::USER_CREATED,
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

    public function login(array $data)
    {
        $user = $this->userRepo->findByEmail($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return ApiResponse::error(
                ApiMessages::INVALID_CREDENTIALS,
                StatusCodes::UNAUTHORIZED
            );
        }

        $tokenResult = $user->createToken('authToken');
        $user->access_token = $tokenResult->accessToken;
        $user->token_type = 'Bearer';

        return ApiResponse::success([
            $user
        ], ApiMessages::LOGIN_SUCCESS);
    }

    public function logout(object $request)
    {
        try {

            $token = $request->user()->currentAccessToken();

            if (!$token) {
                return ApiResponse::error(
                    ApiMessages::TOKEN_NOT_FOUND,
                    StatusCodes::UNAUTHORIZED
                );
            }

            $token->revoke();

            return ApiResponse::success(
                [],
                ApiMessages::LOGOUT_SUCCESS,
                StatusCodes::OK
            );
        } catch (\Throwable $e) {
            return ApiResponse::error(
                ApiMessages::ERROR,
                StatusCodes::SERVER_ERROR,
                $e->getMessage()
            );
        }
    }


    public function forgotPassword(array $data)
    {
        $user = $this->userRepo->findByEmail($data['email']);

        if (!$user) {
            return ApiResponse::error(
                ApiMessages::USER_NOT_FOUND,
                StatusCodes::NOT_FOUND
            );
        }

        // generate token
        $token = Str::random(60);

        // store token
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $data['email']],
            [
                'email' => $data['email'],
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        // Mail::to($data['email'])->send(
        //     new ResetPasswordMail($token, $data['email'])
        // );

        Mail::to($data['email'])->queue(
            new ResetPasswordMail($token, $data['email'])
        );

        return ApiResponse::success([], ApiMessages::RESET_TOKEN_SENT, StatusCodes::OK);
    }


    public function resetPassword(array $data)
    {
        $records = DB::table('password_reset_tokens')->get();

        $record = null;

        foreach ($records as $item) {
            if (Hash::check($data['token'], $item->token)) {
                $record = $item;
                break;
            }
        }

        if (!$record) {
            return ApiResponse::error(
                ApiMessages::INVALID_REQUEST,
                StatusCodes::BAD_REQUEST
            );
        }

        if (Carbon::parse($record->created_at)
            ->addMinutes(15)
            ->isPast()
        ) {

            return ApiResponse::error(
                ApiMessages::INVALID_REQUEST,
                StatusCodes::BAD_REQUEST
            );
        }

        $this->userRepo->updateByEmail($record->email, [
            'password' => $data['password']
        ]);

        DB::table('password_reset_tokens')
            ->where('email', $record->email)
            ->delete();

        return ApiResponse::success(
            [],
            ApiMessages::PASSWORD_RESET_SUCCESS,
            StatusCodes::OK
        );
    }
}
