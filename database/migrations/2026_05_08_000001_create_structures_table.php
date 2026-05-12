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
        Schema::create('structures', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('contact');
            $table->string('email')->unique();
            $table->string('adresse');
            $table->string('commune');
            $table->string('ville');
            $table->string('password');
            $table->string('otp_code')->nullable();
            $table->string('status')->default('pending'); // pending, active, inactive
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('structures');
    }
};
