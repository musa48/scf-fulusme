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
        Schema::create('pemodal_berkas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('pemodal_id');
            $table->string('ktp');
            $table->string('npwp');
            $table->string('swa_photo');
            $table->string('kartu_keluarga');
            $table->string('slip_gaji');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemodal_berkas');
    }
};
