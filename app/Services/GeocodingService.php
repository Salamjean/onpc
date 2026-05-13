<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeocodingService
{
    /**
     * Convertit des coordonnées GPS en adresse lisible via Nominatim (OpenStreetMap)
     */
    public function reverseGeocode($lat, $lng)
    {
        if (!$lat || !$lng) return null;

        try {
            // Utilisation de Nominatim (OpenStreetMap) - Gratuit mais limité en requêtes
            $response = Http::withHeaders([
                'User-Agent' => 'ONPC-Crisis-Management-System'
            ])->timeout(5)->get("https://nominatim.openstreetmap.org/reverse", [
                'format' => 'jsonv2',
                'lat' => $lat,
                'lon' => $lng,
                'addressdetails' => 1,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // On essaie de construire une adresse plus courte et pertinente
                $address = $data['address'] ?? [];
                
                $parts = [];
                if (isset($address['road'])) $parts[] = $address['road'];
                if (isset($address['suburb'])) $parts[] = $address['suburb'];
                if (isset($address['city_district'])) $parts[] = $address['city_district'];
                if (isset($address['city'])) $parts[] = $address['city'];
                if (isset($address['town'])) $parts[] = $address['town'];
                
                if (empty($parts)) {
                    return $data['display_name'] ?? null;
                }

                return implode(', ', array_unique(array_slice($parts, 0, 3)));
            }
        } catch (\Exception $e) {
            Log::error("Erreur de géocodage inverse : " . $e->getMessage());
        }

        return null;
    }
}
