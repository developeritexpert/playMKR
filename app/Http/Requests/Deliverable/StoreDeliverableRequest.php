<?php

namespace App\Http\Requests\Deliverable;

use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class StoreDeliverableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'deal_id' => 'required|exists:deals,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'nullable|string|max:255',
            'deliver_type' => 'required|string|max:255',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,pdf,mp4,mov,avi,webm|max:20480'
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
