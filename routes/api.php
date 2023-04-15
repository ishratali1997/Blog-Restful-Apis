<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\ProfileController;
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

Route::prefix('v1')->group(function () {

    // Guest Routes
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);

    // Auth Routes
    Route::group(["middleware" => ["auth:sanctum"]], function () {
        Route::post('/logout', [LoginController::class, 'logout']);
        Route::post('/update-profile', [ProfileController::class, 'updateProfile']);
        Route::apiResource('/posts', PostController::class);
        Route::post('/delete-post-files', [PostController::class, 'deleteFiles']);

        Route::apiResource('posts.comments', CommentController::class);
    });
});
