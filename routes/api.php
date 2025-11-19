<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AdminArticleController;

// ============================================
// PUBLIC ROUTES (Guest - Tidak perlu login)
// ============================================
Route::post('/register', [AuthController::class, 'register']); 
Route::post('/login', [AuthController::class, 'login']);

// Guest dapat melihat artikel yang sudah published
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{slug}', [ArticleController::class, 'show']);

// ============================================
// AUTHENTICATED ROUTES (User & Admin)
// ============================================
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // ============================================
    // USER ROUTES (User yang login)
    // ============================================
    Route::middleware('user')->group(function () {
        // User melihat artikel milik sendiri
        Route::get('/my-articles', [ArticleController::class, 'myArticles']);
        
        // User CRUD artikel milik sendiri
        Route::post('/my-articles', [ArticleController::class, 'store']);
        Route::put('/my-articles/{id}', [ArticleController::class, 'update']);
        Route::delete('/my-articles/{id}', [ArticleController::class, 'destroy']);
        
        // User submit artikel untuk review
        Route::post('/my-articles/{id}/submit', [ArticleController::class, 'submitForReview']);
    });
    
    // ============================================
    // ADMIN ROUTES (Admin only)
    // ============================================
    Route::middleware('admin')->prefix('admin')->group(function () {
        // Admin melihat semua artikel (dengan filter status)
        Route::get('/articles', [AdminArticleController::class, 'index']);
        
        // Admin melihat artikel pending
        Route::get('/articles/pending', [AdminArticleController::class, 'pending']);
        
        // Admin approve/reject artikel
        Route::post('/articles/{id}/approve', [AdminArticleController::class, 'approve']);
        Route::post('/articles/{id}/reject', [AdminArticleController::class, 'reject']);
        
        // Admin unpublish artikel
        Route::post('/articles/{id}/unpublish', [AdminArticleController::class, 'unpublish']);
        
        // Admin hapus artikel apapun
        Route::delete('/articles/{id}', [AdminArticleController::class, 'destroy']);
    });
});
