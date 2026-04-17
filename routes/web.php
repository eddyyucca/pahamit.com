<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AiAgentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaPostController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware('track.site.visit')->group(function () {
    Route::get('/', HomeController::class)->name('home');

    Route::get('/berita/{slug}',  [PostController::class, 'show'])->name('post.berita');
    Route::get('/panduan/{slug}', [PostController::class, 'show'])->name('post.panduan');
    Route::get('/toko/{slug}',    [PostController::class, 'show'])->name('post.toko');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.store');
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/ai-agent', [AiAgentController::class, 'index'])->name('ai.index');
    Route::post('/ai-agent', [AiAgentController::class, 'storeConversation'])->name('ai.store');
    Route::get('/ai-agent/{conversation}', [AiAgentController::class, 'index'])->name('ai.show');
    Route::put('/ai-agent/{conversation}', [AiAgentController::class, 'updateConversation'])->name('ai.update');
    Route::post('/ai-agent/{conversation}/message', [AiAgentController::class, 'message'])->name('ai.message');
    Route::post('/ai-agent/{conversation}/drafts/{draft}/save', [AiAgentController::class, 'saveDraft'])->name('ai.drafts.save');
    // Preview (draft-safe)
    Route::get('/{type}/{post}/preview', [PostController::class, 'preview'])
        ->whereIn('type', ['berita', 'tutorial', 'jualan'])
        ->name('posts.preview');
    Route::get('/{type}', [MediaPostController::class, 'index'])
        ->whereIn('type', ['berita', 'tutorial', 'jualan'])
        ->name('posts.index');
    Route::get('/{type}/create', [MediaPostController::class, 'create'])
        ->whereIn('type', ['berita', 'tutorial', 'jualan'])
        ->name('posts.create');
    Route::post('/{type}', [MediaPostController::class, 'store'])
        ->whereIn('type', ['berita', 'tutorial', 'jualan'])
        ->name('posts.store');
    Route::get('/{type}/{post}/edit', [MediaPostController::class, 'edit'])
        ->whereIn('type', ['berita', 'tutorial', 'jualan'])
        ->name('posts.edit');
    Route::put('/{type}/{post}', [MediaPostController::class, 'update'])
        ->whereIn('type', ['berita', 'tutorial', 'jualan'])
        ->name('posts.update');
    Route::delete('/{type}/{post}', [MediaPostController::class, 'destroy'])
        ->whereIn('type', ['berita', 'tutorial', 'jualan'])
        ->name('posts.destroy');
});
