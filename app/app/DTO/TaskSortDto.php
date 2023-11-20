<?php 
namespace App\DTO;

class TaskSortDto extends BaseDto{

    public function __construct(
        readonly ?string $sort,
        readonly string $dir = "asc",
    ) {}
    static function setSortAttribute($value){
        return self::camelCaseToSnakeCase($value);
    }
    
}