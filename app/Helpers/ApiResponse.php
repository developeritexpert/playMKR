<?php

namespace App\Helpers;

use App\Constants\StatusCodes;
use App\Constants\ApiMessages;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ApiResponse
{
    public static function success($data = null, string $message = ApiMessages::SUCCESS, int $code = StatusCodes::OK)
    {
        $response = [
            'success'    => true,
            'statusCode' => $code,
            'message'    => $message,
        ];

        if ($data instanceof LengthAwarePaginator) {
            $response['data'] = $data->items();
            $response['pagination'] = [
                'page'        => $data->currentPage(),
                'limit'       => $data->perPage(),
                'totalCount'  => $data->total(),
                'totalPages'  => $data->lastPage(),
                'hasNextPage' => $data->hasMorePages(),
                'hasPrevPage' => $data->currentPage() > 1,
            ];
        } else {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    public static function error(string $message = ApiMessages::ERROR, int $code = StatusCodes::BAD_REQUEST, $errors = null)
    {
        return response()->json([
            'success'    => false,
            'statusCode' => $code,
            'message'    => $message,
            'errors'     => $errors
        ], $code);
    }
}