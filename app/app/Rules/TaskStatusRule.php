<?php

namespace App\Rules;

use App\Enums\TaskStatus;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TaskStatusRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
      
        if(TaskStatus::fromName($value) === false){
            $fail('The :attribute value not supported');
        }
    }
}
