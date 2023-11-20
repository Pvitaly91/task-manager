<?php

namespace Database\Factories;

use App\Enums\TaskPriority;
use App\Models\Task;
use App\Models\User;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class TaskFactory extends Factory
{

    static public function getDataArray($parent_id,$user_id){
     
            
        $status = (rand(0,1) ==1)?TaskStatus::done->value:TaskStatus::todo->value;
        $createdAtTimestamp =  time()+rand(-99999999,0);
        
        return  [
            'title' => fake()->name(),
            'user_id' => $user_id ,
            'parent_id' => $parent_id,//(Task::all()->count() > 0)?Task::all()->random(1)->first()->id:0,
            'description' => fake()->text(),
            'status' => $status,
            'priority' => rand(TaskPriority::min->value,TaskPriority::max->value),
            'created_at' => date("Y-m-d H:i:s",$createdAtTimestamp),
            'updated_at' => date("Y-m-d H:i:s",$createdAtTimestamp),
            'completed_at'=>($status ==1)?date("Y-m-d H:i:s",$createdAtTimestamp+rand(0,time()-$createdAtTimestamp)):NULL
        ];
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $task  =Task::all()->random(1)->first();
      
        return self::getDataArray($task->id,$task->user_id);
    }
}
