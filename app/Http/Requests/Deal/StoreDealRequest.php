<?php
namespace App\Http\Requests\Deal;

use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class StoreDealRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'sponsor_id' => 'required|exists:sponsors,id',
            'deal_title' => 'required|string|max:255',
            'deal_type' => 'required|string|max:50',
            'status' => 'nullable|in:Active,Pending,Completed',
            'deal_description'=> 'required',
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