<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DogController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
});

Route::controller(DogController::class)->group(function () {
    Route::post('dog', 'create');
    Route::get('dogs', 'findAll');
    Route::get('dog/{id}', 'findOne');
    Route::patch('dog/{id}', 'update');
    Route::delete('dog/{id}', 'delete');
});

Route::controller(InteractionController::class)->group(function () {
    Route::post('interaction', 'create');
    Route::get('interaction', 'findAll');
    Route::patch('interaction/{id}', 'update');
    Route::delete('interaction/{id}', 'delete');
});


Route::middleware('auth:sanctum')->get('/me', [UserController::class, 'me'] );