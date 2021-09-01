<?php

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



Route::prefix('user/posts')->group(function () {
    Route::post('',[PostController::class,'getPost']);
    Route::post('/create', [PostController::class,'createPost']);
    Route::post('/{id}/delete',[PostController::class,'deletePost']);
});

