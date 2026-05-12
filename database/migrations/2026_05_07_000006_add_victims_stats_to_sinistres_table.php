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
            $table->integer('nb_morts')->default(0);
            $table->integer('nb_blesses')->default(0);
            $table->integer('nb_evacues')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sinistres', function (Blueprint $table) {
            $table->dropColumn(['nb_morts', 'nb_blesses', 'nb_evacues']);
        });
    }
};
