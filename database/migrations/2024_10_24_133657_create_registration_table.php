<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registration', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('nama_ketua');
            $table->string('nim_ketua');
            $table->string('prodi_ketua');
            $table->string('fakultas_ketua');
            $table->string('nohp_ketua');
            $table->string('nama_ormawa');
            $table->string('judul');
            $table->string('bidang_id');
            $table->text('sk_organisasi');
            $table->text('surat_kerjasama');
            $table->text('surat_rekomendasi_pembina');
            $table->text('proposal');
            $table->string('nama_dosen_pembimbing');
            $table->string('nidn_dosen_pembimbing');
            $table->string('nohp_dosen_pembimbing');
            $table->timestamps();
        });
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('registration_id');
            $table->string('nama');
            $table->string('nim');
            $table->string('prodi');
            $table->string('fakultas');
            $table->string('jabatan');
            $table->timestamps();
        });
        Schema::create('bidang', function (Blueprint $table) {
            $table->id();   
            $table->string('nama');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration');
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('bidang');
    }
};
