<?php



use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\auth\registerController;
use App\Http\Controllers\berandaController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\listPendaftaranController;
use App\Http\Controllers\mhs\mhsController;
use App\Http\Controllers\mhs\regisProgramController;
use App\Http\Controllers\publikasiController;
use App\Http\Controllers\reviewer\ProposalReviewController;
use App\Http\Controllers\reviewer\reviewerController;
use App\Http\Controllers\reviewer\reviewerListPendaftaranController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [loginController::class, 'index'])->name('login');
    Route::post('/login', [loginController::class, 'store'])->name('login.create');
    Route::get('/register', [registerController::class, 'index'])->name('register');
    Route::post('/register', [registerController::class, 'store'])->name('register.create');
    Route::get('/', [berandaController::class, 'index'])->name('beranda');

});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [loginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');
    Route::get('/listPendaftaran', [listPendaftaranController::class, 'index'])->name('listPendaftaran');

    Route::middleware(['can:create publication'])->group(function () {
        Route::get('/publikasi', [publikasiController::class, 'index'])->name('publikasi');
        Route::get('/publikasi/tambah', [publikasiController::class, 'show'])->name('publikasi.tambah');
        Route::get('/publikasi/detail/{id}', [publikasiController::class, 'detail'])->name('publikasi.detail');
        Route::post('/publikasi/tambah', [publikasiController::class, 'store'])->name('publikasi.tambah');
    });
    Route::middleware(['can:edit publication'])->group(function () {
        Route::get('/publikasi/edit/{id}', [publikasiController::class, 'edit'])->name('publikasi.edit');
        Route::post('/publikasi/update/{id}', [publikasiController::class, 'update'])->name('publikasi.update');
    });
    Route::middleware(['can:delete publication'])->group(function () {
        Route::get('/publikasi/delete/{id}', [publikasiController::class, 'destroy'])->name('publikasi.delete');
    });
    Route::middleware(['can:agree publication'])->group(function () {
        Route::get('/publikasi/approve/{id}', [publikasiController::class, 'approve'])->name('publikasi.approve');
    });
    Route::middleware(['can:assessing proposal'])->group(function () {
        Route::get('/reviewer/nilai/{id}', [ProposalReviewController::class, 'index'])->name('reviewer.nilai');
    });
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/approve/{id}', [listPendaftaranController::class, 'approve'])->name('admin.approve');
    });

    Route::middleware(['role:reviewer'])->group(function () {
        Route::get('/reviewer/nilai/{id}', [reviewerListPendaftaranController::class, 'nilai'])->name('reviewer.nilai');
    });
    
    Route::middleware(['role:mahasiswa'])->group(function () {
        Route::get('/daftarProgram', [regisProgramController::class, 'index'])->name('mahasiswa.daftar');
        Route::post('/step', [regisProgramController::class, 'step'])->name('mahasiswa.step');
        Route::post('/daftarProgram', [regisProgramController::class, 'store'])->name('mahasiswa.daftarProgram');
        Route::post('/upload-image', [publikasiController::class, 'uploadImage'])->name('upload.image');
    });
});

