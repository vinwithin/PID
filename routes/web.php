<?php

use App\Http\Controllers\annouceController;
use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\auth\registerController;
use App\Http\Controllers\berandaController;
use App\Http\Controllers\beritaController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\deadlineController;
use App\Http\Controllers\DokumenKegiatanController;
use App\Http\Controllers\DokumenPublikasiController;
use App\Http\Controllers\DokumenTeknisController;
use App\Http\Controllers\excelController;
use App\Http\Controllers\excelMonevController;
use App\Http\Controllers\KelolaArtikel;
use App\Http\Controllers\KelolaKontenController;
use App\Http\Controllers\KelolaOrmawaController;
use App\Http\Controllers\kelolaTimPendamping;
use App\Http\Controllers\laporanAkhirController;
use App\Http\Controllers\LaporanKemajuanController;
use App\Http\Controllers\listPendaftaranController;
use App\Http\Controllers\logbookController;
use App\Http\Controllers\masterDataController;
use App\Http\Controllers\mhs\mhsController;
use App\Http\Controllers\mhs\regisProgramController;
use App\Http\Controllers\MonevController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\publikasiController;
use App\Http\Controllers\reviewer\ProposalReviewController;
use App\Http\Controllers\reviewer\reviewerController;
use App\Http\Controllers\reviewer\reviewerListPendaftaranController;
use App\Models\Berita;
use App\Models\LaporanKemajuan;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::middleware('guest')->group(function () {
    Route::get('/login', [loginController::class, 'index'])->name('login');
    Route::post('/login', [loginController::class, 'store'])->name('login.create');
    Route::get('/register', [registerController::class, 'index'])->name('register');
    Route::post('/register', [registerController::class, 'store'])->name('register.create');
});

Route::get('/', [berandaController::class, 'index'])->name('beranda');
Route::get('/daftar-publikasi', [berandaController::class, 'detailPublikasi'])->name('daftar-publikasi');
Route::get('/video', [berandaController::class, 'video'])->name('video');
Route::get('/tentang-kami', [berandaController::class, 'about'])->name('about');
Route::get('/publikasi/detail/{publikasi:slug}', [berandaController::class, 'detail'])->name('daftar-publikasi');
Route::get('/berita/detail/{berita:slug}', [berandaController::class, 'detailBerita'])->name('detail-berita');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::middleware('auth')->group(function () {
    Route::get('/logout', [loginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [dashboardController::class, 'profil'])->name('profil');
    Route::post('/ganti-foto', [dashboardController::class, 'updateFotoProfil'])->name('update.foto');


    Route::get('/get-dosen', [regisProgramController::class, 'getDosen'])->name('get-dosen');
    Route::get('/get-prodi', [regisProgramController::class, 'getProdi'])->name('get-prodi');

    Route::middleware(['can:read publication', 'checkProgressAcceptAccess'])->group(function () {
        Route::get('/publikasi', [publikasiController::class, 'index'])->name('publikasi');
    });

    Route::middleware(['can:create publication', 'checkProgressAcceptAccess'])->group(function () {
        Route::get('/publikasi/tambah', [publikasiController::class, 'show'])->name('publikasi.tambah');
        Route::get('/publikasi/{id}', [publikasiController::class, 'detail'])->name('publikasi.detail');
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
        Route::get('/publikasi/reject/{id}', [publikasiController::class, 'reject'])->name('publikasi.reject');
        Route::get('/publikasi/cari', [publikasiController::class, 'filter'])->name('publikasi.search');
    });

    Route::middleware(['can:assessing proposal'])->group(function () {
        Route::get('/reviewer/nilai/{id}', [ProposalReviewController::class, 'index'])->name('reviewer.nilai');
        Route::post('/reviewer/nilai/{id}', [ProposalReviewController::class, 'store'])->name('reviewer.nilai');
    });


    Route::middleware(['can:approve proposal'])->group(function () {
        Route::get('pendaftaran/export', [excelController::class, 'export']);
        Route::get('/proposal/approve/{id}', [listPendaftaranController::class, 'approve'])->name('approve');
        Route::get('/proposal/reject/{id}', [listPendaftaranController::class, 'reject'])->name('reject');
        Route::get('/pilih-reviewer/{id}', [listPendaftaranController::class, 'createReviewer'])->name('pilih-reviewer');
        Route::post('/pilih-reviewer/{id}', [listPendaftaranController::class, 'storeReviewer'])->name('pilih-reviewer');
        Route::get('/edit-reviewer/{id}', [listPendaftaranController::class, 'edit'])->name('edit-reviewer');
        Route::post('/update-reviewer/{id}', [listPendaftaranController::class, 'update'])->name('update-reviewer');
        Route::get('/approve-to-program/{id}', [listPendaftaranController::class, 'approveUserForProgram'])->name('approve-to-program');
    });

    Route::middleware(['can:read proposal'])->group(function () {
        Route::get('/pendaftaran', [listPendaftaranController::class, 'index'])->name('pendaftaran');
        Route::get('/pendaftaran/cari', [listPendaftaranController::class, 'filter'])->name('pendaftaran.search');
        Route::get('/pendaftaran/detail/{id}', [listPendaftaranController::class, 'show'])->name('pendaftaran.detail');
        Route::get('/pendaftaran/detail-nilai/{id}', [listPendaftaranController::class, 'scoreDetail'])->name('pendaftaran.detail-nilai');
        Route::get('/pendaftaran/generate-nilai/{id_regis}/{reviewer}', [PdfController::class, 'generate'])->name('pendaftaran.generate-nilai');
    });

    Route::middleware(['can:show logbook'])->group(function () {
        Route::get('/logbook', [logbookController::class, 'index'])->name('logbook')->middleware('checkProgressAccess');
    });
    Route::middleware(['can:validate logbook'])->group(function () {
        Route::get('/logbook/detail/{id}', [logbookController::class, 'detail'])->name('logbook.detail');
        Route::get('/logbook/approve/dospem/{id}', [logbookController::class, 'approve'])->name('logbook.approve');
        Route::get('/logbook/reject/dospem/{id}', [logbookController::class, 'reject'])->name('logbook.reject');
        Route::get('/logbook/approve/admin/{id}', [logbookController::class, 'approveAdmin'])->name('logbook.approveAdmin');
        Route::get('/logbook/reject/admin/{id}', [logbookController::class, 'rejectAdmin'])->name('logbook.rejectAdmin');
    });
    Route::middleware(['can:create logbook'])->group(function () {
        Route::get('/logbook/tambah', [logbookController::class, 'create'])->name('logbook.tambah')->middleware('checkProgressAccess');
        Route::post('/logbook/tambah', [logbookController::class, 'store'])->name('logbook.tambah')->middleware('checkProgressAccess');
        Route::get('/logbook/edit/{id}', [logbookController::class, 'edit'])->name('logbook.edit')->middleware('checkProgressAccess');
        Route::post('/logbook/update/{id}', [logbookController::class, 'update'])->name('logbook.update')->middleware('checkProgressAccess');
    });

    Route::middleware(['can:read laporan kemajuan'])->group(function () {
        Route::get('/laporan-kemajuan', [LaporanKemajuanController::class, 'index'])->name('laporan-kemajuan')->middleware('checkProgressAccess');
    });
    Route::middleware(['can:approve laporan kemajuan'])->group(function () {
        Route::post('/laporan-kemajuan/reject/{id}', [LaporanKemajuanController::class, 'reject'])->name('laporan-kemajuan.reject');
        Route::get('/laporan-kemajuan/approve/{id}', [LaporanKemajuanController::class, 'approve'])->name('laporan-kemajuan.approve');
    });
    Route::middleware(['can:create laporan kemajuan'])->group(function () {
        Route::post('/laporan-kemajuan', [LaporanKemajuanController::class, 'store'])->name('laporan-kemajuan.store')->middleware('checkProgressAccess');
    });

    Route::middleware(['can:read monev'])->group(function () {
        Route::get('/monitoring-evaluasi', [MonevController::class, 'index'])->name('monev.index');
        Route::get('/monitoring-evaluasi/detail/{id}', [MonevController::class, 'detail'])->name('monev.detail');
        Route::get('/monev/generate-nilai/{id_regis}/{reviewer}', [PdfController::class, 'generate_nilai'])->name('monev.generate-nilai');
    });
    Route::middleware(['can:assessing monev'])->group(function () {
        Route::get('/monitoring-evaluasi/nilai/{id}', [MonevController::class, 'createScore'])->name('monev.create');
        Route::post('/monitoring-evaluasi/nilai/{id}', [MonevController::class, 'store'])->name('monev.create');
        Route::post('/monitoring-evaluasi/track', [MonevController::class, 'trackView'])->name('monev.track-view');
    });

    Route::middleware(['can:assign-juri monev'])->group(function () {
        Route::get('/monitoring-evaluasi/reviewer-monev/{id}', [MonevController::class, 'createReviewer'])->name('monev.reviewer');
        Route::post('/monitoring-evaluasi/reviewer-monev/{id}', [MonevController::class, 'storeReviewer'])->name('monev.reviewer');
        Route::get('/monitoring-evaluasi/reviewer-monev/edit/{id}', [MonevController::class, 'edit'])->name('monev.edit');
        Route::post('/monitoring-evaluasi/reviewer-monev/update/{id}', [MonevController::class, 'update'])->name('monev.update');
    });

    Route::middleware(['can:approve monev'])->group(function () {
        Route::get('monitoring-evaluasi/export', [excelMonevController::class, 'export']);
        Route::get('/monitoring-evaluasi/approve/{id}', [MonevController::class, 'approve'])->name('monev.approve');
        Route::get('/monitoring-evaluasi/reject/{id}', [MonevController::class, 'reject'])->name('monev.reject');
    });

    Route::middleware(['can:read final report', 'checkProgressAcceptAccess'])->group(function () {
        Route::get('/laporan-akhir', [laporanAkhirController::class, 'index'])->name('laporan-akhir');
        Route::get('/dokumen-teknis', [DokumenTeknisController::class, 'index'])->name('dokumen-teknis');
        Route::get('/dokumen-publikasi', [DokumenPublikasiController::class, 'index'])->name('dokumen-publikasi');
        Route::get('/dokumentasi-kegiatan', [DokumenKegiatanController::class, 'index'])->name('dokumentasi-kegiatan');
        Route::get('/dokumentasi-kegiatan/album/{id}', [DokumenKegiatanController::class, 'detail'])->name('dokumentasi-kegiatan.album.detail');
        Route::get('/laporan-akhir/detail/{id}', [laporanAkhirController::class, 'detail'])->name('laporan-akhir.detail');
        Route::get('/laporan-akhir/album/{id}', [laporanAkhirController::class, 'detailAlbum'])->name('laporan-akhir.album.detail');
    });
    Route::middleware(['can:create final report', 'checkProgressAcceptAccess'])->group(function () {
        Route::post('/laporan-akhir/file-ketercapaian', [laporanAkhirController::class, 'storeFileKetercapaian'])->name('laporan-akhir.file-ketercapaian');
        Route::post('/laporan-akhir/file', [laporanAkhirController::class, 'storeFile'])->name('laporan-akhir.file');
        Route::post('/laporan-akhir/link', [laporanAkhirController::class, 'storeLink'])->name('laporan-akhir.link');
        Route::post('/laporan-akhir/album', [laporanAkhirController::class, 'storeAlbum'])->name('laporan-akhir.album');

        Route::post('/dokumen-teknis', [DokumenTeknisController::class, 'store'])->name('dokumen-teknis');

        Route::post('/dokumen-publikasi', [DokumenPublikasiController::class, 'store'])->name('dokumen-publikasi');

        Route::post('/dokumentasi-kegiatan', [DokumenKegiatanController::class, 'store'])->name('dokumentasi-kegiatan');
    });

    Route::middleware(['can:update final report', 'checkProgressAcceptAccess'])->group(function () {
        Route::get('/dokumen-teknis/edit/{id}', [DokumenTeknisController::class, 'edit'])->name('dokumen-teknis.edit');
        Route::post('/dokumen-teknis/update/{id}', [DokumenTeknisController::class, 'update'])->name('dokumen-teknis.update');

        Route::get('/dokumen-publikasi/edit/{id}', [DokumenPublikasiController::class, 'edit'])->name('dokumen-publikasi.edit');
        Route::post('/dokumen-publikasi/update/{id}', [DokumenPublikasiController::class, 'update'])->name('dokumen-publikasi.update');

        Route::get('/dokumentasi-kegiatan/edit/{id}', [DokumenKegiatanController::class, 'edit'])->name('dokumentasi-kegiatan.edit');
        Route::post('/dokumentasi-kegiatan/update/{id}', [DokumenKegiatanController::class, 'update'])->name('dokumentasi-kegiatan.update');
    });

    Route::middleware(['can:approve final report', 'checkProgressAcceptAccess'])->group(function () {
        Route::post('/laporan-akhir/reject/{id}', [laporanAkhirController::class, 'reject'])->name('laporan-akhir.reject');
        Route::get('/laporan-akhir/approve/{id}', [laporanAkhirController::class, 'approve'])->name('laporan-akhir.approve');

        Route::post('/laporan-akhir/album/reject/{id}', [laporanAkhirController::class, 'rejectAlbum'])->name('laporan-akhir.album.reject');
        Route::get('/laporan-akhir/album/approve/{id}', [laporanAkhirController::class, 'approveAlbum'])->name('laporan-akhir.album.approve');

        Route::get('/dokumen-teknis/approve/{id}', [DokumenTeknisController::class, 'approve'])->name('dokumen-teknis.approve');
        Route::post('/dokumen-teknis/reject/{id}', [DokumenTeknisController::class, 'reject'])->name('dokumen-teknis.reject');

        Route::get('/dokumen-publikasi/approve/{id}', [DokumenPublikasiController::class, 'approve'])->name('dokumen-publikasi.approve');
        Route::post('/dokumen-publikasi/reject/{id}', [DokumenPublikasiController::class, 'reject'])->name('dokumen-publikasi.reject');

        Route::get('/dokumentasi-kegiatan/approve/{id}', [DokumenKegiatanController::class, 'approve'])->name('dokumentasi-kegiatan.approve');
        Route::post('/dokumentasi-kegiatan/reject/{id}', [DokumenKegiatanController::class, 'reject'])->name('dokumentasi-kegiatan.reject');
    });

    Route::middleware(['can:manage deadline'])->group(function () {
        Route::get('/deadline', [deadlineController::class, 'index'])->name('deadline');
        Route::post('/deadline/update/{id}', [deadlineController::class, 'update'])->name('deadline.update');
        Route::post('/deadline/store', [deadlineController::class, 'store'])->name('deadline.store');
        Route::get('/deadline/destroy/{id}', [deadlineController::class, 'destroy'])->name('deadline.destroy');
    });
    Route::middleware(['can:create deadline'])->group(function () {
        Route::post('/deadline/store', [deadlineController::class, 'store'])->name('deadline.store');
    });


    Route::middleware(['can:manage role'])->group(function () {
        Route::get('/manage-users', [masterDataController::class, 'index'])->name('manage-users');
        Route::get('/manage-users/create', [masterDataController::class, 'create'])->name('manage-users.create');
        Route::post('/manage-users/create', [masterDataController::class, 'store'])->name('manage-users.create');
        Route::get('/manage-users/edit/{id}', [masterDataController::class, 'edit'])->name('manage-users.edit');
        Route::get('/manage-users/delete/{id}', [masterDataController::class, 'destroy'])->name('manage-users.destroy');
        Route::post('/manage-users/update/{id}', [masterDataController::class, 'update'])->name('manage-users.update');
        Route::get('/manage-users/search', [masterDataController::class, 'index'])->name('manage-users.search');

        Route::get('announcement/tambah', [annouceController::class, 'create'])->name('announcement.tambah');
        Route::post('announcement/tambah', [annouceController::class, 'store'])->name('announcement.tambah');
        Route::get('announcement/destroy/{id}', [annouceController::class, 'destroy'])->name('announcement.destroy');
    });
    Route::middleware(['role:admin|super admin'])->group(function () {
        Route::get('announcement', [annouceController::class, 'index'])->name('announcement');
        Route::get('announcement/edit/{id}', [annouceController::class, 'edit'])->name('announcement.edit');
        Route::post('announcement/update/{id}', [annouceController::class, 'update'])->name('announcement.update');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/kelola-konten/video', [KelolaKontenController::class, 'index'])->name('kelola-konten.video');
        Route::get('/kelola-konten/video/create', [KelolaKontenController::class, 'create'])->name('kelola-konten.video.create');
        Route::post('/kelola-konten/video/create', [KelolaKontenController::class, 'store'])->name('kelola-konten.video.store');
        Route::get('/kelola-konten/video/edit/{id}', [KelolaKontenController::class, 'edit'])->name('kelola-konten.video.edit');
        Route::post('/kelola-konten/video/update/{id}', [KelolaKontenController::class, 'update'])->name('kelola-konten.video.update');
        Route::get('/kelola-konten/video/delete/{id}', [KelolaKontenController::class, 'destroy'])->name('kelola-konten.video.destroy');
        Route::post('/update-status-video', [KelolaKontenController::class, 'updateStatus'])->name('update.status-video');
        Route::get('/kelola-konten/foto', [KelolaKontenController::class, 'foto'])->name('kelola-konten.foto');
        Route::get('/kelola-konten/foto/create', [KelolaKontenController::class, 'createFoto'])->name('kelola-konten.foto.create');
        Route::post('/kelola-konten/foto/create', [KelolaKontenController::class, 'storeFoto'])->name('kelola-konten.foto.create');
        Route::get('/kelola-konten/foto/edit/{id}', [KelolaKontenController::class, 'editFoto'])->name('kelola-konten.foto.edit');
        Route::post('/kelola-konten/foto/update/{id}', [KelolaKontenController::class, 'updateFoto'])->name('kelola-konten.foto.update');
        Route::get('/kelola-konten/foto/delete/{id}', [KelolaKontenController::class, 'deleteFoto'])->name('kelola-konten.foto.delete');
        Route::get('/kelola-konten/foto/detail/{id}', [KelolaKontenController::class, 'detail'])->name('kelola-konten.foto.detail');
        Route::post('/update-status-foto', [KelolaKontenController::class, 'updateStatusFoto'])->name('update.status-foto');
        Route::post('/update-status-artikel', [KelolaArtikel::class, 'updateStatus'])->name('update.status-artikel');
        Route::get('/kelola-konten/artikel', [KelolaArtikel::class, 'index'])->name('kelola-konten.artikel');
        Route::get('/berita', [beritaController::class, 'index'])->name('berita');
        Route::get('/berita/create', [beritaController::class, 'create'])->name('berita.create');
        Route::post('/berita/create', [beritaController::class, 'store'])->name('berita.create');
        Route::get('/berita/edit/{id}', [beritaController::class, 'edit'])->name('berita.edit');
        Route::post('/berita/update/{id}', [beritaController::class, 'update'])->name('berita.update');
        Route::get('/berita/delete/{id}', [beritaController::class, 'destroy'])->name('berita.delete');
        Route::get('/berita/detail/{id}', [beritaController::class, 'detail'])->name('berita.detail');
        Route::get('kelola-ormawa/delete/{id}', [KelolaOrmawaController::class, 'destroyFromLink'])->name('kelola-ormawa.destroyFromLink');

        Route::resource('kelola-ormawa', KelolaOrmawaController::class);
    });




    Route::middleware(['role:dosen'])->group(function () {
        Route::get('/kelola-tim-pendamping', [kelolaTimPendamping::class, 'index'])->name('kelola.tim.pendamping');
        Route::get('/kelola-tim-pendamping/approved/{id}', [kelolaTimPendamping::class, 'approve'])->name('kelola.tim.pendamping.approve');
        Route::get('/kelola-tim-pendamping/rejected/{id}', [kelolaTimPendamping::class, 'reject'])->name('kelola.tim.pendamping.reject');
    });

    Route::middleware(['role:mahasiswa'])->group(function () {
        Route::get('/daftarProgram', [regisProgramController::class, 'index'])->name('mahasiswa.daftar');
        Route::get('/approve/{id}', [regisProgramController::class, 'approve'])->name('mahasiswa.approve');
        Route::get('/reject/{id}', [regisProgramController::class, 'reject'])->name('mahasiswa.reject');
        Route::get('/submit/{id}', [regisProgramController::class, 'submit'])->name('mahasiswa.submit')->middleware('allTeamApprove');
        Route::get('/editProgram/{id}', [regisProgramController::class, 'edit'])->name('mahasiswa.edit')->middleware('RegisDeadline');
        Route::post('/step', [regisProgramController::class, 'step'])->name('mahasiswa.step');
        Route::post('/daftarProgram', [regisProgramController::class, 'store'])->name('mahasiswa.daftarProgram');
        Route::post('/updateProgram/{id}', [regisProgramController::class, 'update'])->name('mahasiswa.update')->middleware('RegisDeadline');
        Route::post('/upload-image', [publikasiController::class, 'uploadImage'])->name('upload.image');
        Route::get('/program/cek/{id}', [regisProgramController::class, 'show'])->name('program.cek');
        Route::get('/search-users', [regisProgramController::class, 'search'])->name('users.search');
    });




    Route::get('/api/regencies/jambi', function () {
        $response = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/regencies/15.json");
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
});
