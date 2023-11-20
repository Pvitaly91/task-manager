<?php 

namespace App\DTO;

use App\Enums\TaskStatus;

class TaskDto extends BaseDTO
{
    
    public function __construct(
        readonly ?int $id,
        readonly string $status,
        readonly int $priority,
        readonly string $title,
        readonly string $description,
        readonly string $createdAt,
        readonly ?string $completedAt =null,
        readonly ?array $subTasks = [],
    ) {}
    static function setStatusAttribute($value){
        
        return TaskStatus::from($value)->name;
    }    
}