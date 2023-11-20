<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskSortRequest extends FormRequest
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
            $sort = "in:createdAt,completedAt,priority";
            $dir = "in:asc,desc";
        return [
            "sort" => $sort,
            "sort1" => $sort,
            "dir" => $dir,
            "dir1" => $dir,
        ];
    }
}
