<?php 

namespace App\Http\Requests\Deliverable;

use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateDeliverableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'deal_id' => 'sometimes|exists:deals,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'nullable|string|max:255',
            'deliver_type' => 'sometimes|string|max:255',
            // 'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,pdf,mp4,mov,avi|max:20480'


        'deliver_type_id' =>'nullable|exists:deliver_types,id',     
        'task_id' =>'nullable|exists:tasks,id',
        'sponsor_id' =>'nullable|exists:sponsers,id',
        'assigned_to' =>'nullable|exists:users,id',
        'status' =>'nullable|in:pending,in_progress,completed',
        'priority' =>'nullable|in:low,medium,high',
        'distribution_date' =>'nullable|date',
        'start_date' =>'nullable|date',
        'due_date' =>'nullable|date',
        'attachments' =>'nullable|array',
        'attachments.*' =>'file|mimes:jpg,jpeg,png,mp4,mov,pdf|max:20480',
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