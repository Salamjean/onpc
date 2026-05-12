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
        Schema::create('sinistres', function (Blueprint $バランス) {
            $バランス->id();
            $バランス->string('nom_complet');
            $バランス->string('type_sinistre');
            $バランス->string('contact');
            $バランス->text('description');
            $バランス->string('image1');
            $バランス->string('image2')->nullable();
            $バランス->string('image3')->nullable();
            $バランス->decimal('latitude', 10, 8)->nullable();
            $バランス->decimal('longitude', 11, 8)->nullable();
            $バランス->string('status')->default('en_attente');
            $バランス->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sinistres');
    }
};
