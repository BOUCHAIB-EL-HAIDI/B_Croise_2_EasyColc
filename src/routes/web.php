<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;




use App\Http\Controllers\ColocationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;

Route::get('/' , [HomeController::class , 'welcome'])->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/users/{user}/ban', [AdminController::class, 'banUser'])->name('users.ban');
        Route::post('/users/{user}/unban', [AdminController::class, 'unbanUser'])->name('users.unban');
    });

    Route::get('/profile', [UserController::class, 'show'])->name('profile.show');
    
    Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');
    Route::post('/invitations/{token}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::post('/invitations/{token}/refuse', [InvitationController::class, 'refuse'])->name('invitations.refuse');

    Route::get('/colocations/create', [ColocationController::class, 'create'])->name('colocations.create');
    Route::post('/colocations', [ColocationController::class, 'store'])->name('colocations.store');
    Route::post('/colocations/{colocation}/cancel', [ColocationController::class, 'cancel'])->name('colocations.cancel');
    Route::post('/colocations/leave', [ColocationController::class, 'leave'])->name('colocations.leave');
    Route::post('/colocations/members/{membership}/remove', [ColocationController::class, 'removeMember'])->name('colocations.members.remove');

    Route::post('/settlements/{settlement}/pay', [PaymentController::class, 'initiate'])->name('payments.initiate');
    Route::post('/payments/pay-all/{creditor}', [PaymentController::class, 'payAll'])->name('payments.pay_all');
    Route::post('/payments/{payment}/confirm', [PaymentController::class, 'confirm'])->name('payments.confirm');
    Route::post('/payments/confirm-all/{debtor}', [PaymentController::class, 'confirmAll'])->name('payments.confirm_all');

    // Balance Details
    Route::get('/balances/{user}', [HomeController::class, 'showBalance'])->name('balances.show');

    Route::middleware(['role:owner'])->group(function () {
        Route::get('/invitations', [InvitationController::class, 'index'])->name('invitations.index');
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });

    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
});

Route::get('/invitations/{token}', [InvitationController::class, 'show'])->name('invitations.show');

Route::get('/login' , [AuthController::class , 'showLogin'])->name('login');
Route::post('/login' , [AuthController::class , 'submitLogin']);

Route::get('/register' , [AuthController::class , 'showRegister'])->name('register');
Route::post('/register' , [AuthController::class , 'submitRegister']);

Route::post('/logout' , [AuthController::class , 'logout'])->name('logout');

Route::get('/home' , [HomeController::class , 'index'])->name('home');
