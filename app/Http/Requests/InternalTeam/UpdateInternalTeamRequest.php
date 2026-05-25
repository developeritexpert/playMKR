<?php

namespace App\Http\Requests\InternalTeam;

use App\Constants\ApiMessages;
use Illuminate\Foundation\Http\FormRequest;
use App\Constants\StatusCodes;
use App\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateInternalTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
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