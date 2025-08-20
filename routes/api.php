<?php

use App\Http\Controllers\Api\PostsController as ApiPostsController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/test', function () {
//     return ['message' => 'API is working!'];
// });


Route::get('posts', [ApiPostsController::class, 'index'])->name('api.posts'); // this route to get all posts
Route::get('post/{id}', [ApiPostsController::class, 'show'])->name('api.getPostById'); // this route to get a post by id
