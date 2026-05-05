<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\ApiResponse;
use App\Constants\StatusCodes;
use App\Constants\ApiMessages;
use App\Constants\Roles;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user(); 

        if (!$user) {
            return ApiResponse::error(
                ApiMessages::UNAUTHORIZED,
                StatusCodes::UNAUTHORIZED
            );
        }

        if ($user->role_id !== Roles::ADMIN) {
            return ApiResponse::error(
                ApiMessages::FORBIDDEN,
                StatusCodes::FORBIDDEN
            );
        }

        return $next($request);
    }
}