<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


 

Route::get('users', [ApiController::class, 'index']);   // For listing users
Route::post('users', [ApiController::class, 'store']);  // For creating a user
Route::put('users/{id}', [ApiController::class, 'update']); // For updating a user
Route::delete('users/{id}', [ApiController::class, 'delete']); // For deleting a user
