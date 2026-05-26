<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ApiResponse;
use App\Constants\ApiMessages;
use App\Constants\StatusCodes;

class UpdateTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'deal_id' => 'sometimes|exists:deals,id',
            'sponsor_id' => 'sometimes|exists:sponsors,id',
            'ticket_name' => 'sometimes|string|max:255',
            'number_of_tickets' => 'sometimes|integer|min:1',
            'assigned_to' => 'nullable|exists:users,id',
            'ticket_type' => 'sometimes|in:VIP Pass,General,Backstage',
            'status' => 'nullable|in:Pending,Assigned,Used',
            'distribution_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'ticket_attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
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
