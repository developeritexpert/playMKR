<?php

namespace App\Http\Requests\InternalTeam;

use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreInternalTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
                ApiResponse::error(
                ApiMessages::VALIDATION_FAILED,
                StatusCodes::UNPROCESSABLE_ENTITY,
                $validator->errors()
            )
        );
    }
}