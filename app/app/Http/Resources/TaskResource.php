<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {//
        
        return parent::toArray($request);
       /* return [
          "status" => $this->status,
          "priority" => $this->priority, 
          "title" => $this->title, 
          "description" => $this->description, 
          "createdAt" => $this->created_at, 
          "completedAt" => $this->completed_at, 
        ];*/
    }
}
