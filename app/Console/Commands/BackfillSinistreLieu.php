<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sinistre;
use App\Services\GeocodingService;

class BackfillSinistreLieu extends Command
{
    protected $signature = 'sinistre:backfill-lieu';
    protected $description = 'Remplit le champ lieu des sinistres existants via leurs coordonnées GPS';

    public function handle()
    {
        $sinistres = Sinistre::whereNull('lieu')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        $this->info("Analyse de {$sinistres->count()} sinistres sans lieu...");

        $geocoder = new GeocodingService();
        $bar = $this->output->createProgressBar($sinistres->count());

        foreach ($sinistres as $sinistre) {
            $address = $geocoder->reverseGeocode($sinistre->latitude, $sinistre->longitude);
            
            if ($address) {
                $sinistre->update(['lieu' => $address]);
            }
            
            $bar->advance();
            // Petite pause pour respecter les limites de l'API Nominatim (1 req / sec)
            sleep(1);
        }

        $bar->finish();
        $this->info("\nTerminé !");
    }
}
