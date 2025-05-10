<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->enum('status_publish', ['yes', 'no']);
            $table->timestamps();
        });
        DB::table('document_types')->insert([
            ['name' => 'Dokumen manual/panduan', 'status_publish' => 'yes', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'proposal', 'status_publish' => 'no', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'laporan_keuangan', 'status_publish' => 'no', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'laporan_keuangan', 'status_publish' => 'no', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'laporan_keuangan', 'status_publish' => 'no', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'laporan_keuangan', 'status_publish' => 'no', 'created_at' => now(), 'updated_at' => now()],
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
