<?php
namespace App\Repositories;

use App\Models\Task;

class TaskRepository  implements RepositoryInterface{
    public int $userId;

    private array $sort = [];

    private $query;
    private bool $withTree = false; //get tree of sub-tasks for selected task
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
        ],
        readonly string $fullTextQuery = "MATCH(description,title) AGAINST(? IN NATURAL LANGUAGE MODE)" // 
    ){
        $this->userId = Request()->user()->id;
    }
    public function setTreeFlag(bool $tatus){
        $this->withTree = $tatus;
    }
    /**
     * initial default query setting
     *
     * @return void
     */
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
    
    protected function getSubTasksFromArray($withTree = true){
        if(($tasks = $this->query->get()) == true && $withTree == true){
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

    public function getById(int $id){
   
        $this->initDafaultTaskQuery();

        $task = $this->query
            ->where("id",$id)->first()
            ?->toArray();
        
        if($task != NULL && $this->withTree == true)
            $this->getSubTasks($task);

        return $task;
    }
    public  function getByCriteria(array $filter){
        $this->initDafaultTaskQuery();
        
        foreach($filter as $filterName => $value){
            if($value !== NULL){
                if($filterName == "query")
                    $this->query->whereRaw($this->fullTextQuery, $value);
                else
                    $this->query->where($filterName,$value);
            }
                
        }
        
        return $this->getSubTasksFromArray($this->withTree);
    }
    public function fullTextSearch(string $query){
        $this->initDafaultTaskQuery();
        $this->query->whereRaw($this->fullTextQuery, $query);
        return $this->getSubTasksFromArray($this->withTree);
    }
}