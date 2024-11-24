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
        Schema::create('dokumen_teknis', function (Blueprint $table) {
            $table->id();
            $table->string('file_manual');
            $table->string('status_manual');
            $table->string('file_bukti_publikasi');
            $table->string('status_publikasi');
            $table->string('file_proposal');
            $table->string('file_laporan_keuangan');

            $table->string('file_artikel');
            $table->string('status_artikel');
            $table->string('link_artikel');
            $table->string('file_haki');
            $table->string('status_haki');
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
