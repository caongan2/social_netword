<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

Route::group(['middleware'=>'api'],function () {
    Route::get('/user-profile',[AuthController::class,'userProfile']);
    Route::get('/user-list',[UserController::class,'getAll']);
});

Route::prefix('users')->group(function (){
        Route::put('/{id}/update-profile',[UserController::class,'update']);
});
