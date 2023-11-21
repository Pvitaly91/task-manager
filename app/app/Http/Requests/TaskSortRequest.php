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
        $rules = [];
        //set quantity of sort fields
        for($i=0; $i<2; $i++){
            $suf = ($i == 0)?"":$i;
            $rules["sort".$suf] = "in:createdAt,completedAt,priority";
            $rules["dir".$suf] = "in:asc,desc"; 
        }
      
        return $rules;
    }
}
