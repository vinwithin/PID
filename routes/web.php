<?php


use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\auth\registerController;
use App\Http\Controllers\dashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [loginController::class, 'index'])->name('login');
    Route::post('/login', [loginController::class, 'store'])->name('login.create');
    Route::get('/register', [registerController::class, 'index'])->name('register');
    Route::post('/register', [registerController::class, 'store'])->name('register.create');

});

Route::middleware('auth')->group(function () {
    Route::get('/', function(){
        return view('welcome');
    });
    Route::prefix('admin')->group(function () {
        Route::get('/', [dashboardController::class, 'index'])->name('admin.dashboard');
    });

});
