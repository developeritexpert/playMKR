<?php
namespace App\Http\Requests\Sponsor;

use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateSponsorRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'company_name' => 'sometimes|required|string|max:255',
            'sponser_name' => 'sometimes|required|string|max:255',
            'email' => 'nullable|email|unique:sponsors,email,' . $this->route('id'),
            'phone' => 'nullable|string|max:20',
            'industry' => 'nullable',
            'website' => 'nullable',
            'primary_contact' => 'nullable',
            'location' => 'nullable',
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