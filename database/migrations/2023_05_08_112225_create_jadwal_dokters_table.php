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
        Schema::create('jadwal_dokters', function (Blueprint $table) {
            $table->id();
            $table->string('kodepoli');
            $table->string('namapoli');
            $table->string('kodesubspesialis');
            $table->string('namasubspesialis');
            $table->string('kodedokter');
            $table->string('namadokter');
            $table->string('hari');
            $table->string('namahari');
            $table->string('jadwal');
            $table->string('kapasitaspasien');
            $table->string('libur');
            $table->string('user_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_dokters');
    }
};
