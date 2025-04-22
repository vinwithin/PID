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
        Schema::create('media_dokumentasi', function (Blueprint $table) {
            $table->id();
            $table->string('team_id');
            $table->string('link_youtube');
            $table->string('link_social_media');
            $table->string('link_dokumentasi');
            $table->string('status');
            $table->text('komentar')->nullable();
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
