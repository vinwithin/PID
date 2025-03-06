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
        Schema::create('dokumen_publikasi', function (Blueprint $table) {
            $table->id();
            $table->string('team_id');
            $table->string('file_artikel');
            $table->string('status_artikel');
            $table->string('link_artikel');
            $table->string('file_haki');
            $table->string('status_haki');
            $table->string('status');
           
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
