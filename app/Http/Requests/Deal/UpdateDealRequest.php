<?php
namespace App\Http\Requests\Deal;

use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateDealRequest extends FormRequest
{
    public function authorize() { 
        return true; 
    }

    public function rules()
    {
        return [
            'deal_title' => 'sometimes|required|string|max:255',
            'deal_type' => 'sometimes|required|string|max:50',
            'status' => 'nullable|in:Active,Pending,Completed',
            'deal_description' => 'required'
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