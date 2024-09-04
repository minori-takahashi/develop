<?php

// use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\PostController;

Route::get('/', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
// Route::post('/images', [ImageUploadController::class, 'upload'])->name('upload.image');
