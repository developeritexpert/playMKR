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
            'deal_id' => 'required|exists:deals,id',
            'sponsor_id' => 'required|exists:sponsors,id',
            'invoice_title' => 'required|string|max:255',
            'invoice_amount' => 'required|numeric',
            'tax' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'total_amount' => 'required|numeric',
            'currency' => 'required|string',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'payment_status' => 'required|in:Pending,Paid,Overdue',
            'billing_address' => 'nullable|string',
            'contact_email' => 'nullable|email',
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
