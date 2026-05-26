<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Helpers\ApiResponse;
use App\Constants\StatusCodes;
use App\Constants\ApiMessages;
use App\Constants\Roles;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return ApiResponse::error(
                ApiMessages::UNAUTHORIZED,
                StatusCodes::UNAUTHORIZED
            );
        }


        $allowedRoles = collect($roles)
            ->map(function ($role) {
                return constant(Roles::class . '::' . strtoupper($role));
            })
            ->toArray();

        

        if (!in_array($user->role_id, $allowedRoles)) {
            return ApiResponse::error(
                ApiMessages::FORBIDDEN,
                StatusCodes::FORBIDDEN,
            );
        }

        return $next($request);
    }
}