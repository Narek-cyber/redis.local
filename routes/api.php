<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/cached', [PostController::class, 'getCachedIndex'])->name('posts.cached.index');
Route::get('posts/{id}', [PostController::class, 'show'])->name('posts.show');
Route::post('posts', [PostController::class, 'store'])->name('posts.store');
