<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('groupe_personnes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('groupe_id')->constrained('users')->cascadeOnDelete();
            $table->string('nom_complet');
            $table->string('telephone', 20)->nullable();
            $table->string('fonction')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('groupe_personnes');
    }
};
