<?php 

namespace App\DTO;

use App\Enums\TaskStatus;

class TaskDto extends BaseDTO
{
    
    public function __construct(
        readonly ?int $id=null,
        readonly ?string $status=null,
        readonly ?int $priority=null,
        readonly ?string $title=null,
        readonly ?string $description=null,
        readonly ?string $createdAt=null,
        readonly ?string $completedAt =null,
        readonly ?array $subTasks = [],
    ) {}
    static function setStatusAttribute($value){
        
        return TaskStatus::from($value)->name;
    }    
}