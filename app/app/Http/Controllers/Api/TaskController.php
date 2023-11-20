<?php

namespace App\Http\Controllers\Api;

use App\DTO\TaskDto;
use App\Models\Task;
use App\DTO\TaskStoreDto;
use App\Services\TaskService;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Repositories\TaskRepository;
use App\Http\Requests\TaskSortRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskFilterRequest;

class TaskController extends Controller
{
 
    protected $taskRepository;
    /**
     * Display a listing of the resource.
     */
    public function index(
        TaskFilterRequest $filterRequest,
        TaskSortRequest $sortRequest,
        TaskRepository $taskRepository
    )
    {
       
        $taskService = new TaskService($taskRepository,$sortRequest,$filterRequest);

        return  TaskResource::collection($taskService->getData());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
     
        $data = TaskStoreDto::fromArray($request->validated())->toArray();
        $createdTask = Task::create($data)->toArray();
       
        return new TaskResource(TaskDto::fromArray($createdTask)->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id,TaskRepository $taskRepository)
    {
     
        if(($task = $taskRepository->getById($id)) != true){
            abort("404","Not found");
        }
    
        return new TaskResource(TaskDto::fromArray($task));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskStoreRequest $request, Task $task)
    {
        $data = TaskStoreDto::fromArray($request->validated())->toArray();
        $task->update($data);
       
        return new TaskResource(TaskDto::fromArray($task->toArray())->toArray());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->noContent();
    }
}
