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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('google_id')->nullable();
            $table->string('username')->nullable()->unique();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('avatar_original')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('user_verify')->nullable();
            $table->string('id_simrs')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
