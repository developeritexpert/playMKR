<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ApiResponse;
use App\Constants\ApiMessages;
use App\Constants\Roles;
use App\Constants\StatusCodes;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id'  => 'required|in:' . Roles::INTERNAL_TEAM . ',' . Roles::SPONSOR,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Name is required',
            'email.required'    => 'Email is required',
            'email.email'       => 'Email is invalid',
            'email.unique'      => 'Email is already taken',
            'password.required' => 'Password is required',
            'password.min'      => 'Password must be at least 8 characters long',
            'role_id.required'  => 'Role is required',
            'role_id.in'        => 'Role is invalid',
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