<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Factories\TaskFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RootTasksSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i<= 20; $i++){
            \App\Models\Task::create(TaskFactory::getDataArray(0,User::all()->random(1)->first()->id));
        }
        
    }
}
