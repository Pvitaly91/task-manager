<?php
namespace App\Repositories;

use App\Models\Task;

class TaskRepository{
    public int $userId;

    private array $sort = [];

   
    private $query;
    public function __construct(
        readonly array $select = [
            "id",
            "parent_id",
            "status",
            "priority", 
            "title", 
            "description", 
            "created_at", 
            "completed_at"
        ]
    ){
        $this->userId = Request()->user()->id;
    }
  
    protected function initDafaultTaskQuery(){
        $this->query = Task::query()
            ->select($this->select)->where("user_id",$this->userId);

        foreach($this->sort as $order){
            $this->query->orderBy($order->sort,$order->dir);
        }            
    }
    

    private function getSubTasks(Task|array &$task){
        if(($subTasks = $this->getTree($task["id"])) == true)
            $task["subTasks"] = $subTasks; 
    }
    protected function getSubTasksFromArray(){
        if(($tasks = $this->query->get()) == true){
            //making tasks tree
            foreach($tasks as &$task){
                $this->getSubTasks($task);
            }
        }
        return $tasks;
    }
    protected function getTree(int $id){
        $this->initDafaultTaskQuery();
        
        $this->query->where("parent_id",$id);
 
        return $this->getSubTasksFromArray()->toArray();  
    }
    public function setOrder(array $sort):void{
        $this->sort = $sort;
    } 

    public function getAll(){
        $this->initDafaultTaskQuery();
        $this->query->where("parent_id",0); //get root tasks
        
        return $this->getSubTasksFromArray();
    }

    public function getById($id){
   
        $this->initDafaultTaskQuery();

        $task = $this->query
            ->where("id",$id)->first()
            ?->toArray();
        
        if($task != NULL)
            $this->getSubTasks($task);

        return $task;
    }
    public  function getByCriteria(array $filter){
        $this->initDafaultTaskQuery();
        
        foreach($filter as $filterName => $value){
            if($value !== NULL)
                $this->query->where($filterName,$value);
        }
        
        return $this->getSubTasksFromArray();
    }
}