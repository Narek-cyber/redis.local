<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RedisPostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('posts')
    ->controller(PostController::class)
    ->as('posts.')
    ->group(function () {
        Route::get('', [PostController::class, 'index'])->name('index');
        Route::get('cached', [PostController::class, 'getCachedIndex'])->name('cached.index');
        Route::get('{id}', [PostController::class, 'show'])->name('show');
        Route::post('', [PostController::class, 'store'])->name('store');
    });


Route::prefix('redis/posts')
    ->controller(RedisPostController::class)
    ->as('redis.posts.')
    ->group(function () {
        Route::get('', [RedisPostController::class, 'index'])->name('index');
        Route::get('{id}', [RedisPostController::class, 'show'])->name('show');
        Route::post('', [RedisPostController::class, 'store'])->name('store');
    });



