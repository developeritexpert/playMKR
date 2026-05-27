<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ApiResponse;
use App\Constants\ApiMessages;
use App\Constants\StatusCodes;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'deal_id' => 'required|exists:deals,id',
            'sponsor_id' => 'required|exists:sponsors,id',
            'ticket_name' => 'required|string|max:255',
            'number_of_tickets' => 'required|integer|min:1',
            'assigned_to' => 'nullable|exists:users,id',
            'ticket_type' => 'required|in:VIP Pass,General,Backstage',
            'distribution_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'ticket_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
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
