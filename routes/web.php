<?php

use Illuminate\Support\Facades\Route;

// ===============================
// HOME & AUTH PAGES
// ===============================
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', function () {
    return view('login.index');
})->name('login');

Route::get('/register', function () {
    return view('login.register');
})->name('register');

Route::get('/lihat-artikel', function () {
    return view('lihat');
})->name('lihat');

// Article detail page (public)
Route::get('/articles/{slug}', function () {
    return view('article-detail');
})->name('article.detail');

// ===============================
// USER CRUD PAGES (TANPA CONTROLLER)
// ===============================

// Dashboard
Route::get('/user/dashboard', fn() => view('user.dashboard'))->name('user.dashboard');

// Create Page
Route::get('/user/create', fn() => view('user.create'))->name('user.create');

// Update Page (pakai {id} untuk dummy)
Route::get('/user/edit/{id}', fn($id) => view('user.update', ['id' => $id]))->name('user.edit');

// Delete Page (popup tetap pakai file delete.blade.php)
Route::get('/user/delete/{id}', fn($id) => view('user.delete', ['id' => $id]))->name('user.delete');

// ===============================
// ADMIN PAGES
// ===============================
Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
Route::get('/admin/articles', fn() => view('admin.list_article'))->name('list_article');
Route::get('/admin/articles/{id}', fn($id) => view('admin.detail_article', ['id' => $id]))->name('detail_article');
Route::get('/admin/create', fn() => view('admin.create'))->name('admin.create');
Route::get('/admin/edit/{id}', fn($id) => view('admin.edit', ['id' => $id]))->name('admin.edit');
Route::get('/admin/delete/{id}', fn($id) => view('admin.delete', ['id' => $id]))->name('admin.delete');