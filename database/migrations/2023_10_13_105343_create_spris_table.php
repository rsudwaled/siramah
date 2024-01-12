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
        Schema::create('spris', function (Blueprint $table) {
            $table->id();
            $table->string('noSPRI');
            $table->date('tglRencanaKontrol')->nullable();
            $table->string('namaDokter')->nullable();
            $table->string('noKartu')->nullable();
            $table->string('nama')->nullable();
            $table->string('kelamin')->nullable();
            $table->date('tglLahir')->nullable();
            $table->string('namaDiagnosa')->nullable();

            $table->string('kodeDokter')->nullable();
            $table->string('poliKontrol')->nullable();
            $table->string('user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spris');
    }
};
