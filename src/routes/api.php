<?php

use App\Http\Controllers\PostsController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/v1/test', function () {
    return response(['foo' => 'bar'])->send();
});

Route::prefix('/v1')->group(function () {
    Route::controller(PostsController::class)->prefix('posts')->group(function () {
        Route::get('/', [PostsController::class, 'listAllPosts'])->name('posts.list');
        Route::get('/{code}', [PostsController::class, 'getPost'])->name('posts.get');
        Route::post('/', [PostsController::class, 'createPost'])->name('posts.create');
        Route::patch('/{code}', [PostsController::class, 'editPost'])->name('posts.edit');
        Route::delete('/{code}', [PostsController::class, 'deletePost'])->name('posts.create');
    });
});
