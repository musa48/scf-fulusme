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
        Schema::create('akun_bank', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('pemodal_id');
            $table->string('nomer_rekening');
            $table->string('nama_pemilik_rekening');
            $table->string('nama_bank');
            $table->string('nama_bank_kustodian');
            $table->string('nama_pemilik_rekening_kustodian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun_banks');
    }
};
