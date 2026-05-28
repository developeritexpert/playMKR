<?php

namespace App\Http\Requests\Sponsor;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ApiResponse;
use App\Constants\ApiMessages;
use App\Constants\StatusCodes;

class SponsorApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:sponsor_applications,email',
            'contact_number'    => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'website_url' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'The email has already been taken.',  
            'contact_number.required' => 'The contact number field is required.',
            'company_name.required' => 'The company name field is required.',
            'website_url.required' => 'The website url field is required.',
            'industry.required' => 'The industry field is required.',
            'address.required' => 'The address field is required.',
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
