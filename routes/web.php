<?php



use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\auth\registerController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\listPendaftaranController;
use App\Http\Controllers\mhs\mhsController;
use App\Http\Controllers\mhs\publikasiController;
use App\Http\Controllers\mhs\regisProgramController;

use App\Http\Controllers\reviewer\reviewerController;
use App\Http\Controllers\reviewer\reviewerListPendaftaranController;
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
    Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');
    Route::get('/listPendaftaran', [listPendaftaranController::class, 'index'])->name('listPendaftaran');

    Route::middleware(['role:admin'])->group(function () {
        // Route::get('/admin/listPendaftaran', [listPendaftaranController::class, 'index'])->name('admin.listPendaftaran');
        Route::get('/admin/approve/{id}', [listPendaftaranController::class, 'approve'])->name('admin.approve');
    });
    Route::middleware(['role:reviewer'])->group(function () {
        Route::get('/reviewer/nilai/{id}', [reviewerListPendaftaranController::class, 'nilai'])->name('reviewer.nilai');

    });
    Route::middleware(['role:mahasiswa'])->group(function () {
        Route::get('/daftarProgram', [regisProgramController::class, 'index'])->name('mahasiswa.daftar');
        Route::post('/step', [regisProgramController::class, 'step'])->name('mahasiswa.step');
        Route::post('/daftarProgram', [regisProgramController::class, 'store'])->name('mahasiswa.daftarProgram');
        Route::get('/publikasi', [publikasiController::class, 'index'])->name('mahasiswa.publikasi');
        Route::get('/publikasi/tambah', [publikasiController::class, 'show'])->name('mahasiswa.publikasi.tambah');
        Route::get('/publikasi/detail/{id}', [publikasiController::class, 'detail'])->name('mahasiswa.publikasi.detail');
        Route::post('/publikasi/tambah', [publikasiController::class, 'store'])->name('mahasiswa.publikasi.tambah');
        Route::post('/upload-image', [publikasiController::class, 'uploadImage'])->name('upload.image');

    });
    
    
    


});

