<?php

namespace App\Http\Requests\DeliverType;

use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateDeliverTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name' => 'required|string|max:255|unique:deliver_types,name,' . $id
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = [];
        foreach ($validator->errors()->all() as $error) {
            $errors[] = $error;
        }
        throw new HttpResponseException(
            ApiResponse::error(
                ApiMessages::VALIDATION_FAILED,
                StatusCodes::UNPROCESSABLE_ENTITY,
                $errors
            )
        );
    }
}