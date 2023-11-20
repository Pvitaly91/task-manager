<?php

namespace App\Http\Requests;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Rules\TaskStatusRule;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
          //  'user_id' => 'exists:App\Models\User,id',
            "parent_id" => 'nullable|exists:App\Models\Task,id',
            "priority" => 'required|integer|between:'.TaskPriority::min->value.",".TaskPriority::max->value,
            "title" => "required|max:255",
            "description" => "required|string", 
            "status" => new TaskStatusRule,
            "completed_at" => "date_format:Y-m-d H:i:s"
        ];
    }
}
