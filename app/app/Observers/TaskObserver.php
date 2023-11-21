<?php

namespace App\Observers;

use App\Enums\TaskStatus;
use App\Models\Task;

class TaskObserver
{
    protected $userId;

    function __construct(){
       
        $this->userId = Request()->user()->id;
    }
    /**
     * Handle the Task "creating" event.
     */
    public function creating(Task $task): void
    {
        $task->user_id = $this->userId;
    }
    
    function forbidden($id,$action){
        if($this->userId != $id){
            Abort(403,$action." not allowed");
        } 
    }
    /**
     * Handle the Task "updating" event.
     */
    public function updating(Task $task): void
    {
        $this->forbidden($task->user_id,"Update");
        //check if we try to change task status and can change status
        if(!$task->checkEditableStatus() && $task->getTaskStatus() != $task->status){
            Abort(403,"Update not allowed");
        }
    }

    /**
     * Handle the Task "deleting" event.
     */
    public function deleting(Task $task): void
    {   
        $this->forbidden($task->user_id,"Delete");
       
        if($task->status == TaskStatus::todo->value || $task->childExist())
            Abort(403,"Delete not allowed");
        
    }
    
}
