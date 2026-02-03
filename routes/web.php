<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/login', fn () => view('auth.login'))->name('login');

Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

Route::get('/users', fn () => view('users.index'))->name('users.index');
Route::get('/users/create', fn () => view('users.create'))->name('users.create');
