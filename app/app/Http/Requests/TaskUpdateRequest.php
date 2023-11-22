<?php

namespace App\Http\Requests;

use App\Rules\TaskStatusRule;
use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends TaskStoreRequest
{
   
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = parent::rules();
        $rules["status"] = new TaskStatusRule;
        return $rules;
    }
}
