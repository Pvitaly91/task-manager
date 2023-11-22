<?php

namespace App\Rules;

use App\Repositories\RepositoryInterface;
use App\Repositories\TaskRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TaskParentIdRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $taskRepository = new TaskRepository(["id","user_id"]);
       
        if($value > 0 &&  !$taskRepository->getById($value)){
            $fail('The task with '.$attribute.' value not found');
        }
   
    }
}
