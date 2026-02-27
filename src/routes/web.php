<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;




use App\Http\Controllers\ColocationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvitationController;

Route::get('/' , [HomeController::class , 'welcome'])->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'show'])->name('profile.show');
    
    Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');
    Route::post('/invitations/{token}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');

    Route::get('/colocations/create', [ColocationController::class, 'create'])->name('colocations.create');
    Route::post('/colocations', [ColocationController::class, 'store'])->name('colocations.store');
    Route::post('/colocations/{colocation}/cancel', [ColocationController::class, 'cancel'])->name('colocations.cancel');
});

Route::get('/invitations/{token}', [InvitationController::class, 'show'])->name('invitations.show');

Route::get('/login' , [AuthController::class , 'showLogin'])->name('login');
Route::post('/login' , [AuthController::class , 'submitLogin']);

Route::get('/register' , [AuthController::class , 'showRegister'])->name('register');
Route::post('/register' , [AuthController::class , 'submitRegister']);

Route::post('/logout' , [AuthController::class , 'logout'])->name('logout');

Route::get('/home' , [HomeController::class , 'index'])->name('home');
