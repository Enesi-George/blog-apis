<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\InteractController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::middleware('token')->group(function () {
    Route::apiResource('blogs', BlogController::class);
    
    Route::apiResource('blogs.posts', PostController::class);
    
    Route::post('posts/{post}/like', [InteractController::class, 'likePost']);
    Route::post('posts/{post}/comment', [InteractController::class, 'commentPost']);
});