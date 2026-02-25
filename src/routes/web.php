<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
Route::get('/' , [HomeController::class , 'index']);
Route::get('/auth/register' , [AuthController::class , 'showRegister']);
Route::get('/auth/login' , [AuthController::class , 'showLogin']);
