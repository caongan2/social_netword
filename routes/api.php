<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::prefix('posts')->group(function (){
    Route::get('', [PostController::class, 'index']);
    Route::post('/create', [PostController::class, 'create']);
    Route::post('/{id}/update', [PostController::class, 'update']);
    Route::post('/{id}/delete', [PostController::class, 'delete']);
});


Route::post('/register', [AuthController::class, 'register']);
Route::get('posts', [PostController::class, 'index']);
Route::post('edit/{id}', [PostController::class, 'update']);






