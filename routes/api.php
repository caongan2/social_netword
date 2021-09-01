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


Route::group(['middleware' => 'api'], function () {

    Route::prefix('auth')->group(function (){
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login',[AuthController::class,'login']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::prefix('posts')->group(function (){
        Route::get('/getAll', [PostController::class, 'index']);
        Route::post('/create', [PostController::class, 'create']);
        Route::post('/{id}/update', [PostController::class, 'update']);
        Route::post('/{id}/delete', [PostController::class, 'delete']);
    });


});










