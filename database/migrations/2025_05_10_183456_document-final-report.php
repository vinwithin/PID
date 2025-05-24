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
         Schema::create('document_final_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('team_id');
            $table->integer('document_type_id');
            $table->string('content');
            $table->string('publish_status')->nullable();
            $table->enum('status', ['Belum Valid', 'Valid', 'Ditolak']);
            $table->text('komentar');
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
