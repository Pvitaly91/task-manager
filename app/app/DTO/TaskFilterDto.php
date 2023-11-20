<?
namespace App\DTO;

use App\Enums\TaskStatus;
use App\Models\Task;

class TaskFilterDto extends BaseDto{

    protected static $toCamelCase = false;
    public function __construct(
        readonly ?string $status = null,
        readonly ?int $priority =null,
        readonly ?string $title =null,
        readonly ?string $description =null,
        readonly ?string $created_at =null,
        readonly ?string $completed_at =null
    ) {}
    
    static function setStatusAttribute($value){
        return TaskStatus::fromName($value);
    }
 
}