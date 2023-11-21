<?php
namespace App\DTO;

use App\Enums\TaskStatus;

class TaskStoreDto extends BaseDTO
{
    protected static $toCamelCase = false;
    public function __construct(
        readonly ?int $parent_id = null,
        readonly ?int $priority = null,
        readonly ?string $status = null,
        readonly ?string $title = null,
        readonly ?string $description = null,
    ) {}

    static function setStatusAttribute($value){
        
        return TaskStatus::fromName($value);
    }

}