<?php
namespace App\DTO;

use App\Enums\TaskStatus;

class TaskStoreDto extends BaseDTO
{
    protected static $toCamelCase = false;
    public function __construct(
        readonly int $parent_id,
        readonly int $priority,
        readonly string $status,
        readonly string $title,
        readonly string $description,
    ) {}

    static function setStatusAttribute($value){
        
        return TaskStatus::fromName($value);
    }

}