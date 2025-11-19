<?php

use Illuminate\Support\Facades\Route;

// ===============================
// AUTH PAGES
// ===============================
Route::get('/login', function () {
    return view('login.index');
})->name('login');

Route::get('/register', function () {
    return view('login.register');
})->name('register');

Route::get('/lihat-artikel', function () {
    return view('lihat');
})->name('lihat');

// ===============================
// USER CRUD PAGES (TANPA CONTROLLER)
// ===============================

// Dashboard
Route::get('/user/dashboard', fn() => view('user.dashboard'));

// Create Page
Route::get('/user/create', fn() => view('user.create'));

// Update Page (pakai {id} untuk dummy)
Route::get('/user/edit/{id}', fn($id) => view('user.update', ['id' => $id]));

// Delete Page (popup tetap pakai file delete.blade.php)
Route::get('/user/delete/{id}', fn($id) => view('user.delete', ['id' => $id]));