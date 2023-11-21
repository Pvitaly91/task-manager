<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//Auth::loginUsingId(3);

  Route::group(['middleware' => 'auth:sanctum'], function(){  
    Route::prefix('tasks')->group(function () {
      Route::put('changeStatus/{task}', [TaskController::class,'changeStatus']);
    });
    Route::apiResource('tasks', TaskController::class);
    
  });
