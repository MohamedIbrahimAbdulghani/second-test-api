<?php

use App\Http\Controllers\Api\PostsController as ApiPostsController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// Route::get('/test', function () {
//     return ['message' => 'API is working!'];
// });


// Route::post('login', [AuthController::class, 'login']);
// Route::post('register', [AuthController::class, 'register']);
// Route::post('logout', [AuthController::class, 'logout']);
// Route::post('refresh', [AuthController::class, 'refresh']);
// Route::get('me', [AuthController::class, 'me']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

Route::get('posts', [ApiPostsController::class, 'index'])->name('api.posts'); // this route to get all posts
Route::get('post/{id}', [ApiPostsController::class, 'show'])->name('api.getPostById'); // this route to get a post by id
Route::post('posts', [ApiPostsController::class, 'store'])->name('api.store'); // this route to added new post by postman
Route::PUT('posts/{id}', [ApiPostsController::class, 'update'])->name('api.update'); // this route to update a post by postman
Route::DELETE('posts/{id}', [ApiPostsController::class, 'delete'])->name('api.delete'); // this route to delete post by id
