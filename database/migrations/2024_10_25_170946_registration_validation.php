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
        Schema::create('registration_validation', function (Blueprint $table) {
            $table->id();
            $table->string('registration_id');
            $table->string('status')->default('belum valid');
            $table->text('catatan')->nullable();
            $table->string('validator_id')->nullable(); // jika ingin menyimpan siapa yang memvalidasi
            $table->timestamp('validated_at')->nullable();
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
