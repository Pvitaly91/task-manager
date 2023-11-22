<?php

namespace App\Http\Requests;

use App\Enums\TaskPriority;
use App\Rules\TaskParentIdRule;
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
            "parent_id" => ['nullable', new TaskParentIdRule],//'nullable|exists:App\Models\Task,id',
            "priority" => 'required|integer|between:'.TaskPriority::min->value.",".TaskPriority::max->value,
            "title" => "required|max:255",
            "description" => "required|string", 
        ];
    }
}
