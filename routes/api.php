<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User routes
    Route::put('/profile', [UserController::class, 'updateProfile']);
    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/users/search', [UserController::class, 'search']);
    Route::get('/users/{id}', [UserController::class, 'getUserProfile']);
    Route::get('/followers', [UserController::class, 'followers']);
    Route::get('/following', [UserController::class, 'following']);
    Route::post('/follow/{id}', [UserController::class, 'follow']);
    Route::delete('/unfollow/{id}', [UserController::class, 'unfollow']);
    
    // Post routes
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{id}', [PostController::class, 'show']);
    Route::post('/posts/{id}/like', [PostController::class, 'like']);
    Route::delete('/posts/{id}/unlike', [PostController::class, 'unlike']);
    Route::post('/posts/{id}/comment', [PostController::class, 'comment']);
    Route::delete('/posts/{postId}/comment/{commentId}', [PostController::class, 'deleteComment']);
    Route::get('/my-posts', [PostController::class, 'myPosts']);
    Route::get('/posts-by-user/{id}', [PostController::class, 'postsByUserId']);
    Route::get('/following-posts', [PostController::class, 'followingPosts']);
    Route::get('/liked', [PostController::class, 'likedPosts']);
});