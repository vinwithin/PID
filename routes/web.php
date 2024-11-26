<?php



use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\auth\registerController;
use App\Http\Controllers\berandaController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\DokumenKegiatanController;
use App\Http\Controllers\DokumenPublikasiController;
use App\Http\Controllers\DokumenTeknisController;
use App\Http\Controllers\listPendaftaranController;
use App\Http\Controllers\mhs\mhsController;
use App\Http\Controllers\mhs\regisProgramController;
use App\Http\Controllers\publikasiController;
use App\Http\Controllers\reviewer\ProposalReviewController;
use App\Http\Controllers\reviewer\reviewerController;
use App\Http\Controllers\reviewer\reviewerListPendaftaranController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [loginController::class, 'index'])->name('login');
    Route::post('/login', [loginController::class, 'store'])->name('login.create');
    Route::get('/register', [registerController::class, 'index'])->name('register');
    Route::post('/register', [registerController::class, 'store'])->name('register.create');

});
Route::get('/', [berandaController::class, 'index'])->name('beranda');
Route::get('/daftar-publikasi', [berandaController::class, 'detailPublikasi'])->name('daftar-publikasi');

Route::middleware('auth')->group(function () {
    Route::get('/logout', [loginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['can:create publication'])->group(function () {
        Route::get('/publikasi', [publikasiController::class, 'index'])->name('publikasi');
        Route::get('/publikasi/tambah', [publikasiController::class, 'show'])->name('publikasi.tambah');
        Route::get('/publikasi/detail/{id}', [publikasiController::class, 'detail'])->name('publikasi.detail');
        Route::post('/publikasi/tambah', [publikasiController::class, 'store'])->name('publikasi.tambah');

        Route::get('/dokumen-teknis', [DokumenTeknisController::class, 'index'])->name('dokumen-teknis');
        Route::get('/dokumen-publikasi', [DokumenPublikasiController::class, 'index'])->name('dokumen-publikasi');
        Route::get('/dokumentasi-kegiatan', [DokumenKegiatanController::class, 'index'])->name('dokumentasi-kegiatan');


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
        Route::get('/publikasi/cari', [publikasiController::class, 'filter'])->name('publikasi.search');

    });
    Route::middleware(['can:assessing proposal'])->group(function () {
        Route::get('/reviewer/nilai/{id}', [ProposalReviewController::class, 'index'])->name('reviewer.nilai');
        Route::post('/reviewer/nilai/{id}', [ProposalReviewController::class, 'store'])->name('reviewer.nilai');
    });
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/approve/{id}', [listPendaftaranController::class, 'approve'])->name('approve');
        Route::get('/approve-to-program/{id}', [listPendaftaranController::class, 'approveUserForProgram'])->name('approve-to-program');
    });

    Route::middleware(['role:admin|reviewer'])->group(function () {
        Route::get('/pendaftaran', [listPendaftaranController::class, 'index'])->name('pendaftaran');
        Route::get('/pendaftaran/cari', [listPendaftaranController::class, 'filter'])->name('pendaftaran.search');
        Route::get('/pendaftaran/detail/{id}', [listPendaftaranController::class, 'show'])->name('pendaftaran.detail');
        Route::get('/pendaftaran/detail-nilai/{id}', [listPendaftaranController::class, 'scoreDetail'])->name('pendaftaran.detail-nilai');
        // Route::get('/reviewer/nilai/{id}', [reviewerListPendaftaranController::class, 'nilai'])->name('reviewer.nilai');
    });

    Route::middleware(['role:mahasiswa'])->group(function () {
        Route::get('/daftarProgram', [regisProgramController::class, 'index'])->name('mahasiswa.daftar');
        Route::post('/step', [regisProgramController::class, 'step'])->name('mahasiswa.step');
        Route::post('/daftarProgram', [regisProgramController::class, 'store'])->name('mahasiswa.daftarProgram');
        Route::post('/upload-image', [publikasiController::class, 'uploadImage'])->name('upload.image');
        Route::get('/program/cek/{id}', [regisProgramController::class, 'show'])->name('program.cek');
    });


    
    Route::get('/api/provinces', function () {
        $response = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json');
        return response()->json($response->json());
    });
    Route::get('/api/regencies/{provinceId}', function ($provinceId) {
        $response = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/regencies/{$provinceId}.json");
        return response()->json($response->json());
    });
    
    // Untuk Kecamatan
    Route::get('/api/districts/{regencyId}', function ($regencyId) {
        $response = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/districts/{$regencyId}.json");
        return response()->json($response->json());
    });
    
    // Untuk Desa
    Route::get('/api/villages/{districtId}', function ($districtId) {
        $response = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/villages/{$districtId}.json");
        return response()->json($response->json());
    });
    Route::get('/search-users', [regisProgramController::class, 'search'])->name('users.search');
});

