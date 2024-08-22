<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssignmentsController;

Route::post('/regester',[AuthController::class,'regester']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth:sanctum');


Route::group(['middleware' => ['auth:sanctum','check-permission:admin']], function () { 
    Route::apiResource('user',UserController::class);
});


Route::apiResource('project',ProjectController::class)->middleware('auth:sanctum','check-permission:admin,editor');
Route::apiResource('task',TaskController::class)->middleware('auth:sanctum','check-permission:admin,editor');
Route::apiResource('assignment',AssignmentsController::class)->middleware('auth:sanctum','check-permission:admin,editor');
Route::put('/task/{task}/status',[TaskController::class,'updateStatus'])->middleware('auth:sanctum');

Route::get('/notify/{email}',[TaskController::class,'notify'])->middleware('auth:sanctum');