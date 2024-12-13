<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\API\CommentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/posts', [PostController::class, 'index']);
Route::middleware('auth:sanctum')->get('/posts', [PostController::class, 'index']);
Route::middleware('auth:sanctum')->get('/posts/{id}', [PostController::class, 'show']);
Route::middleware('auth:sanctum')->post('/posts', [PostController::class, 'store']);
Route::middleware('auth:sanctum')->put('/posts/{id}', [PostController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/posts/{id}', [PostController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/posts/{postId}/comments', [UserController::class, 'index']);
Route::middleware('auth:sanctum')->get('/posts/{postId}/comments/{commentId}', [UserController::class, 'show']);
Route::middleware('auth:sanctum')->post('/posts/{postId}/comments', [UserController::class, 'store']);
Route::middleware('auth:sanctum')->put('/posts/{postId}/comments/{commentId}', [UserController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/posts/{postId}/comments/{commentId}', [UserController::class, 'destroy']);

Route::apiResource('posts', PostController::class);
Route::apiResource('users', UserController::class);
Route::post('login', [AuthController::class, 'login']);