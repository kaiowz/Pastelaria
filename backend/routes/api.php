<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PastryController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');

Route::prefix('auth')->group(function(){
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

});

Route::prefix('user')->group(function(){
    Route::post('/', [UserController::class, 'create']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::get('/{id}', [UserController::class, 'index']);
    Route::get('/', [UserController::class, 'index']);
    Route::delete('/{id}', [UserController::class, 'delete']);
});

Route::prefix('pastry')->group(function(){
    Route::post('/', [PastryController::class, 'create']);
    Route::put('/{id}', [PastryController::class, 'update']);
    Route::get('/{id}', [PastryController::class, 'index']);
    Route::get('/', [PastryController::class, 'index']);
    Route::delete('/{id}', [PastryController::class, 'delete']);
});

Route::prefix('order')->group(function(){
    Route::post('/', [OrderController::class, 'create']);
    Route::put('/{id}', [OrderController::class, 'update']);
    Route::get('/{id}', [OrderController::class, 'index']);
    Route::get('/', [OrderController::class, 'index']);
    Route::delete('/{id}', [OrderController::class, 'delete']);
});
