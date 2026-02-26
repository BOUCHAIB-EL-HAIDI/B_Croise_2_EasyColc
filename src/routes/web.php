<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
Route::get('/' , [HomeController::class , 'index'])->name('home');

Route::get('/login' , [AuthController::class , 'showLogin'])->name('login');
Route::post('/login' , [AuthController::class , 'submitLogin']);

Route::get('/register' , [AuthController::class , 'showRegister'])->name('register');
Route::post('/register' , [AuthController::class , 'submitRegister']);

Route::post('/logout' , [AuthController::class , 'logout'])->name('logout');
