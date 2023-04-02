<?php

use App\Http\Controllers\Api\GroupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthController;

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

Route::prefix('auth')->group(function () {
    Route::post('login',[AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}/show', [UserController::class, 'show']);
    Route::post('/create', [UserController::class, 'store'])->middleware('auth:api');
    Route::patch('/{id}/update', [UserController::class, 'update'])->middleware('auth:api');
    Route::delete('/{id}/delete', [UserController::class, 'delete'])->middleware('auth:api');
    Route::post('/{id}/attach-groups', [UserController::class, 'attachGroups'])->middleware('auth:api');
});

Route::get('/groups', [GroupController::class, 'index']);
Route::get('/groups/{id}/show', [GroupController::class, 'show']);
