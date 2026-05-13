<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('sinistres', 'etat_des_lieux_documents')) {
            Schema::table('sinistres', function (Blueprint $table) {
                $table->json('etat_des_lieux_documents')->nullable()->after('nb_evacues');
            });
        }

        if (Schema::hasColumn('sinistres', 'etat_des_lieux_document')) {
            DB::table('sinistres')
                ->whereNotNull('etat_des_lieux_document')
                ->orderBy('id')
                ->get(['id', 'etat_des_lieux_document'])
                ->each(function ($sinistre) {
                    DB::table('sinistres')
                        ->where('id', $sinistre->id)
                        ->update([
                            'etat_des_lieux_documents' => json_encode([$sinistre->etat_des_lieux_document]),
                        ]);
                });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Migration corrective: on ne supprime rien automatiquement pour eviter de perdre des donnees.
    }
};
