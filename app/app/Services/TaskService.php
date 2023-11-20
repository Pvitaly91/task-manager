<?php 
namespace App\Services;

use App\DTO\TaskDto;
use App\DTO\TaskSortDto;
use App\DTO\TaskFilterDto;
use App\Repositories\TaskRepository;
use App\Http\Requests\TaskSortRequest;
use App\Http\Requests\TaskFilterRequest;

class TaskService{
    protected $data;
    function __construct(
        readonly TaskRepository $taskRepository,
        readonly TaskSortRequest $sortRequest,   
        readonly TaskFilterRequest $filterRequest
        )
    {
        $this->sort();   
        $this->filter();
    }
    protected function sort(){
        if(($sort = $this->sortRequest->validated()) == true){
            $validated = [];
            for($i=0; $i<=1; $i++){
                $suf = ($i==0)?"":$i;
                $fSort = (isset($sort["sort".$suf]))?$sort["sort".$suf]:NULL;
                $fDir = (isset($sort["dir".$suf]))?$sort["dir".$suf]:"desc";
                if($fSort != NULL)
                    $validated[] = new TaskSortDto($fSort,$fDir);
                
            }
            $this->taskRepository->setOrder($validated);
        }
    }

    protected function filter(){
        if(($filter = $this->filterRequest->validated()) == true ){    
            $filter = TaskFilterDto::fromArray($filter)->toArray();
            $tasks = $this->taskRepository->getByCriteria($filter)->toArray();
            $this->data = TaskDto::collection($tasks);
        }else{
            $this->data = TaskDto::collection($this->taskRepository->getAll()->toArray());
        }
    }

    public function getData(){
        return $this->data;
    }
   
}