<?php

namespace App\Http\Controllers\Api\Citizen;

use App\Http\Controllers\Controller;
use App\Models\Sinistre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SinistreApiController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_complet' => 'required|string|max:255',
            'type_sinistre' => 'required|string',
            'contact' => 'required|string|max:20',
            'description' => 'required|string',
            'image1' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'lieu' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['nom_complet', 'type_sinistre', 'contact', 'description', 'latitude', 'longitude', 'lieu']);

        // Stockage des images
        try {
            if ($request->hasFile('image1')) {
                $data['image1'] = $request->file('image1')->store('sinistres', 'public');
            }
            if ($request->hasFile('image2')) {
                $data['image2'] = $request->file('image2')->store('sinistres', 'public');
            }
            if ($request->hasFile('image3')) {
                $data['image3'] = $request->file('image3')->store('sinistres', 'public');
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du stockage des images',
                'error' => $e->getMessage()
            ], 500);
        }

        // Géocodage inverse automatique si le lieu n'est pas fourni
        if (empty($data['lieu']) && $data['latitude'] && $data['longitude']) {
            $geocoder = new \App\Services\GeocodingService();
            $address = $geocoder->reverseGeocode($data['latitude'], $data['longitude']);
            if ($address) {
                $data['lieu'] = $address;
            }
        }

        // Création du sinistre ou fusion s'il existe déjà
        $sinistre = Sinistre::createOrMerge($data);

        // Recherche de la caserne la plus proche si la position est disponible et que le sinistre est nouvellement créé
        if ($sinistre->wasRecentlyCreated && $sinistre->latitude && $sinistre->longitude) {
            $this->assignNearestCasernes($sinistre);
        }

        $message = $sinistre->wasRecentlyCreated
            ? 'Votre déclaration a été enregistrée avec succès. Les secours ont été informés.'
            : 'Votre déclaration a été ajoutée à un incident en cours dans votre zone. Les secours ont été informés.';

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [
                'id' => $sinistre->id,
                'reference' => $sinistre->reference ?? null,
                'lieu' => $sinistre->lieu,
                'was_recently_created' => $sinistre->wasRecentlyCreated
            ]
        ], $sinistre->wasRecentlyCreated ? 201 : 200);
    }

    private function assignNearestCasernes(Sinistre $sinistre)
    {
        $lat = $sinistre->latitude;
        $lng = $sinistre->longitude;

        $casernes = User::where('role', 'caserne')
                        ->where(function($q) {
                            $q->where('status', 'active')->orWhereNull('status');
                        })
                        ->get();

        $distances = [];

        foreach ($casernes as $caserne) {
            if ($caserne->latitude && $caserne->longitude) {
                $distance = $this->haversineGreatCircleDistance(
                    $lat, $lng, $caserne->latitude, $caserne->longitude
                );
                
                $distances[] = [
                    'id' => $caserne->id,
                    'distance' => $distance
                ];
            }
        }

        usort($distances, function($a, $b) {
            return $a['distance'] <=> $b['distance'];
        });

        $nearest = array_slice($distances, 0, 1);

        foreach ($nearest as $item) {
            $sinistre->casernes()->attach($item['id'], ['distance' => $item['distance']]);
        }
    }

    private function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
    {
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        
        return $angle * $earthRadius;
    }
}
