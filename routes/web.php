<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/articles', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('login.index');
})->name('login');

Route::get('/register', function () {
    return view('login.register');
})->name('register');

Route::get('/lihat-artikel', function () {
    return view('lihat');
})->name('lihat');
