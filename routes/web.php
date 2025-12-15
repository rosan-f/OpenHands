<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\CommentController;


Route::get('/', [HomeController::class, 'index'])->name('home');


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // Post
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/post', [PostController::class, 'create'])->name('posts.create');
    Route::post('/post', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Like
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');

    // Share
    Route::post('/posts/{post}/share', [ShareController::class, 'store'])->name('posts.share');

    // Comment
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // donation
    Route::get('/donations', [PostController::class, 'donations'])->name('donations.create');
});
