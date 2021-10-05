<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [App\Http\Controllers\UserController::class, 'register']);
Route::post('login', [App\Http\Controllers\UserController::class, 'login']);

Route::middleware('auth:api')->post('profile/{id}/follow', [App\Http\Controllers\UserController::class, 'followUser']);
Route::middleware('auth:api')->post('profile/{id}/unfollow', [App\Http\Controllers\UserController::class, 'UnfollowUser']);
Route::middleware('auth:api')->get('profile/{id}/followers', [App\Http\Controllers\UserController::class, 'getFollowers']);
Route::middleware('auth:api')->get('profile/{id}/following', [App\Http\Controllers\UserController::class, 'getFollowing']);


Route::middleware('auth:api')->post('posts/create', [App\Http\Controllers\PostController::class, 'create']);
Route::middleware('auth:api')->get('posts/{id}', [App\Http\Controllers\PostController::class, 'read']);
Route::middleware('auth:api')->put('posts/{id}', [App\Http\Controllers\PostController::class, 'update']);
Route::middleware('auth:api')->delete('posts/{id}', [App\Http\Controllers\PostController::class, 'delete']);
Route::middleware('auth:api')->delete('profile/{id}/posts', [App\Http\Controllers\PostController::class, 'posts']);
