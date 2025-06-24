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
        Schema::create('reviewer_access_proposal', function (Blueprint $table) {
            $table->id();
            $table->integer('reviewer_id'); // atau tabel reviewers jika ada
            $table->integer('pendaftaran_id'); // relasi ke proposal atau pendaftaran
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviewer_access_proposal');
    }
};
