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
        Schema::create('document_registration', function (Blueprint $table) {
            $table->id();
            $table->string('registration_id');
            $table->text('sk_organisasi');
            $table->text('surat_kerjasama');
            $table->text('surat_rekomendasi_pembina');
            $table->text('proposal');
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
