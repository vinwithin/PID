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
        Schema::create('document_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('status', ['File', 'File & Ketercapaian', 'Link']);
            $table->timestamps();
        });
        DB::table('document_types')->insert([
            ['name' => 'Dokumen manual/panduan', 'status' => 'File & Ketercapaian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Draf proposal PPK Ormawa untuk tahun  berikutnya', 'status' => 'File', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dokumen Laporan Keuangan', 'status' => 'File', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'File draf artikel berita media massa', 'status' => 'File & Ketercapaian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bukti ketercapaian HAKI (Sertifikat HAKI/draf pendaftaran HAKI)', 'status' => 'File & Ketercapaian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bukti ketercapaian seminar atau publikasi artikel', 'status' => 'File & Ketercapaian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tautan Artikel', 'status' => 'Link', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tautan video YouTube', 'status' => 'Link', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tautan media sosial', 'status' => 'Link', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tautan google drive dokumentasi kegiatan', 'status' => 'Link', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
