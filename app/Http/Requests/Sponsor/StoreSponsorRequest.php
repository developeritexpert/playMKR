<?php
namespace App\Http\Requests\Sponsor;

use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreSponsorRequest extends FormRequest
{
    public function authorize() {
         return true;
         }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'sponser_name' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'email' => 'required|email|unique:sponsors,email',
            'phone' => 'required|string|max:20',
            'website' => 'required',
            'primary_contact' => 'required',
            'location' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'company_name.required' => 'Company name is required',
            'sponser_name.required' => 'Sponsor name is required',
            'industry.required' => 'Industry is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'email.unique' => 'Email already exists',
            'phone.required' => 'Phone is required',
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