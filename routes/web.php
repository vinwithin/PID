<?php

use App\Http\Controllers\admin\dashboardController;
use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\auth\registerController;
use App\Http\Controllers\mhs\mhsController;
use App\Http\Controllers\mhs\regisProgramController;
use App\Http\Controllers\reviewer\reviewerController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [loginController::class, 'index'])->name('login');
    Route::post('/login', [loginController::class, 'store'])->name('login.create');
    Route::get('/register', [registerController::class, 'index'])->name('register');
    Route::post('/register', [registerController::class, 'store'])->name('register.create');

});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [loginController::class, 'logout'])->name('logout');
    Route::get('/', function(){
        return view('welcome');
    });
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [dashboardController::class, 'index'])->name('admin.dashboard');
    });
    Route::middleware(['role:reviewer'])->group(function () {
        Route::get('/reviewer/dashboard', [reviewerController::class, 'index'])->name('reviewer.dashboard');
    });
    Route::middleware(['role:mahasiswa'])->group(function () {
        Route::get('/dashboard', [mhsController::class, 'index'])->name('mahasiswa.dashboard');
        Route::get('/daftarProgram', [regisProgramController::class, 'index'])->name('mahasiswa.daftar');
        Route::post('/step', [regisProgramController::class, 'step'])->name('mahasiswa.step');
        Route::post('/daftarProgram', [regisProgramController::class, 'store'])->name('mahasiswa.daftarProgram');

    });
    
    
    


});

