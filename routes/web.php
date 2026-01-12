<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleAuthController;
use Illuminate\Support\Facades\Route;

// Public blog routes
Route::get('/', [PostController::class, 'index'])->name('posts.index');

// Comment routes (public can comment)
Route::post('/posts/{post:slug}/comments', [CommentController::class, 'store'])->name('comments.store');

// Google Login
Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Post management - IMPORTANT: specific routes must come before dynamic routes
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/posts/create/pin', [PostController::class, 'createPin'])->name('posts.create.pin');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post:slug}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::patch('/posts/{post:slug}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post:slug}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Comment deletion
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Admin dashboard
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    // Like routes
    Route::post('/posts/{post:slug}/like', [\App\Http\Controllers\LikeController::class, 'toggle'])->name('posts.like');

    // Board routes
    Route::post('/boards', [\App\Http\Controllers\BoardController::class, 'store'])->name('boards.store');
    Route::post('/posts/{post:slug}/save-to-board', [\App\Http\Controllers\BoardController::class, 'savePost'])->name('posts.save-to-board');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Download route (public)
Route::get('/posts/{post:slug}/download', [\App\Http\Controllers\BoardController::class, 'downloadLink'])->name('posts.download');

// Public post view - MUST come after /posts/create to avoid route conflict
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

require __DIR__ . '/auth.php';
