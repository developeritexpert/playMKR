<?php

namespace App\Http\Requests\Invoice;

use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateInvoiceRequest extends FormRequest
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
            'deal_id' => 'exists:deals,id',
            'sponsor_id' => 'exists:sponsors,id',
            'invoice_title' => 'string|max:255',
            'invoice_amount' => 'numeric',
            'tax' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'total_amount' => 'numeric',
            'currency' => 'string',
            'invoice_date' => 'date',
            'due_date' => 'date',
            'payment_status' => 'in:Pending,Paid,Overdue',
            'billing_address' => 'nullable|string',
            'contact_email' => 'nullable|email',
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
