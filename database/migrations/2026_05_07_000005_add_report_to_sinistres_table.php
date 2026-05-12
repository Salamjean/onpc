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
        Schema::table('sinistres', function (Blueprint $table) {
            $table->text('rapport_intervention')->nullable();
            $table->timestamp('date_cloture')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sinistres', function (Blueprint $table) {
            $table->dropColumn(['rapport_intervention', 'date_cloture']);
        });
    }
};
