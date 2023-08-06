<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\TopicController;
use \App\Http\Controllers\RequestController;




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Users
// ************************************************************
Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);


 //   Categories
 // ************************************************************
Route::get('categories',[CategoryController::class,'all_categories']);
Route::post('add_category',[CategoryController::class,'add_category']);
Route::post('update_category/{id}',[CategoryController::class,'update_category']);
Route::delete('category/{id}',[CategoryController::class,'delete_category']);



//   Topics
 // ************************************************************
Route::get('topics',[TopicController::class,'all_topics']);
Route::post('add_topic',[TopicController::class,'add_topic']);
Route::post('update_topic/{id}',[TopicController::class,'update_topic']);
Route::delete('topic/{id}',[TopicController::class,'delete_topic']);



//   Requests
 // ************************************************************
Route::get('requests',[RequestController::class,'all_requests']);
Route::post('add_request',[RequestController::class,'add_request']);
Route::post('update_request/{id}',[RequestController::class,'update_request']);
Route::delete('request/{id}',[RequestController::class,'delete_request']);
