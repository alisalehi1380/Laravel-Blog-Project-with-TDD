<?php

use App\Http\Controllers\Auth\AuthenticateController;
use Illuminate\Support\Facades\Route;

Route::view('/login', 'auth.login')->name('show.login')->middleware('guest');
Route::post('/login', [AuthenticateController::class, 'login'])->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::post('/register', [AuthenticateController::class, 'register'])->name('register.normall.user');
Route::any('/logout', [AuthenticateController::class, 'logout'])->name('logout')->middleware('auth');
