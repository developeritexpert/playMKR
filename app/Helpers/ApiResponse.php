<?php

namespace App\Helpers;
use App\Constants\StatusCodes;
use App\Constants\ApiMessages;

class ApiResponse
{
    public static function success($data = null, string $message = ApiMessages::SUCCESS, int $code = StatusCodes::OK)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error(string $message = ApiMessages::ERROR, int $code = StatusCodes::BAD_REQUEST, $errors = null)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }
}