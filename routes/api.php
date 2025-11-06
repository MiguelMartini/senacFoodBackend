<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ReceitasController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function (){
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
    Route::patch('users/edit/{id}', [UserController::class, 'update']);
    
    Route::get('receitas', [ReceitasController::class, 'index']);
    Route::post('receitas', [ReceitasController::class, 'store']);
});