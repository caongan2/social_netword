<?php


use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Firebase\FriendController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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
        Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.password');
        Route::prefix('users')->group(function (){
            Route::put('{id}/update-profile',[UserController::class,'update']);
            Route::get('{id}/listFriend',[FriendController::class,'listFriend']);
            Route::get('{id}/requestFriend',[FriendController::class,'requestFriend']);
            Route::get('{id}/addFriend',[FriendController::class,'addFriend']);
            Route::delete('{id}/deleteRequest',[FriendController::class,'deleteRequest']);
            Route::get('{id}/acceptFriend',[FriendController::class,'acceptFriend']);
            Route::get('listUsers',[FriendController::class,'listUsers']);
            Route::get('{id}/listFriendByUser',[FriendController::class,'listFriendByUser']);
        });
        Route::post('loginGoogle',[AuthController::class,'loginGoogle']);
    });


    Route::get('/{id}/user-profile',[AuthController::class,'userProfile']);
    Route::get('/user-list',[UserController::class,'getAll']);
    Route::get('/findUser',[UserController::class,'findUser']);


    Route::prefix('posts')->group(function (){
        Route::get('/getPostByUser/{id}', [PostController::class, 'getPostByUser']);
        Route::get('/getAll', [PostController::class, 'index']);
        Route::post('/create', [PostController::class, 'create']);
        Route::put('/{id}/update', [PostController::class, 'update']);
        Route::delete('/{id}/delete', [PostController::class, 'delete']);
        Route::get('/{id}/showPost', [PostController::class, 'showPost']);
        Route::get('/{id}/likePost', [PostController::class, 'likePost']);
        Route::delete('/{id}/disLike', [PostController::class, 'disLike']);
        Route::get('/{id}/countLike', [PostController::class, 'countLikeByPost']);
        Route::get('/{id}/getRelationShip', [PostController::class, 'getRelationShip']);
    });


    Route::prefix('comment')->group(function (){
        Route::get('commentByPost/{id}', [CommentController::class, 'index']);
        Route::delete('delete/{id}', [CommentController::class, 'destroy']);
        Route::get('show-comment/{id}', [CommentController::class, 'showComment']);
        Route::post('create', [CommentController::class, 'comment']);
        Route::post('update/{id}', [CommentController::class, 'update']);
        Route::get('like-comment/{id}', [CommentController::class, 'likeComment']);
    });

});

