<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
return view('home');
});


Route::resource('tasks', TaskController::class);
Route::get('tasks/{id}', [TaskController::class, 'show']);
Route::get('taskEdit/{id}', [TaskController::class, 'edit']);
Route::PUT('taskUpdate/{id}', [TaskController::class, 'update'])->name('taskUpdate');
Route::get('taskDelete/{id}', [TaskController::class, 'destroy']);
Route::POST('filterTask', [TaskController::class, 'filterTask'])->name('filterTask');


Route::resource('projects', ProjectController::class);
Route::get('projectAll', [ProjectController::class, 'index']);
Route::get('projectEdit/{id}', [ProjectController::class, 'edit']);
Route::get('projectDelete/{id}', [ProjectController::class, 'destroy']);