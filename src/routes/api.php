<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostsController;
use App\Http\Middleware\CommentForCodeExists;
use App\Http\Middleware\PostForCodeExists;
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
    # /posts/ endpoints
    Route::controller(PostsController::class)->prefix('posts')->group(function () {
        Route::get('/', 'listWithFilter')->name('posts.list');
        Route::post('/', 'createPost')->name('posts.create');
        Route::middleware([PostForCodeExists::class])->group(function () {
            Route::get('/{code}', 'getPost')->name('posts.get');
            Route::patch('/{code}', 'editPost')->name('posts.edit');
            Route::delete('/{code}', 'deletePost')->name('posts.delete');
        });
    });

    # /comments/ endpoints
    Route::controller(CommentsController::class)->prefix('comments')->group(function () {
        Route::get('/', 'listWithFilter')->name('comments.list');
        Route::post('/', 'createComment')->name('comments.create');
        Route::middleware([CommentForCodeExists::class])->group(function () {
            Route::get('/{code}', 'getComment')->name('comments.get');
            Route::patch('/{code}', 'editComment')->name('comments.edit');
            Route::delete('/{code}', 'deleteComment')->name('comments.delete');
        });
    });
});
