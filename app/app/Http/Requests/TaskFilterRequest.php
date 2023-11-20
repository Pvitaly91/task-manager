<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use App\Enums\TaskPriority;
use App\Rules\TaskStatusRule;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TaskFilterRequest extends FormRequest
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
            "priority" => 'integer|between:'.TaskPriority::min->value.",".TaskPriority::max->value,
            "title" => "max:255",
            "description" => "string", 
            "status" => ["string",new TaskStatusRule]
        ];
    }
}
