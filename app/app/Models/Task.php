<?php

namespace App\Models;

use App\Enums\TaskStatus;
use App\Events\TaskCreating;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

   
    protected $fillable = [
        "priority",
        "parent_id",
        "title",
        "description",
        "status",
        "completed_at",
    ];

    public function childExist(){
        return (bool)$this->query()->select("id")->where("parent_id", $this->id)->first();
    }
    protected function checkTree($tasks){
        $status = true;
        foreach($tasks as $task){
            if($task["status"] == TaskStatus::todo->value){
                return false;
            }
            if(isset($task["subTasks"])){
               $status = $this->checkTree($task["subTasks"]);
            }
            if($status == false)
                return $status;
        }
        return $status;
    }
    public function checkEditableStatus(){
        $status = true;
        $repository = new TaskRepository(["id","status"]);
        $task = $repository->getById($this->id);

        if(isset($task["subTasks"])){
            return $this->checkTree($task["subTasks"]);
        }
        return $status;
    }
    //public function getStatusAttribute($value){

   //     return TaskStatus::from($value)->name;
   // }
  
}
