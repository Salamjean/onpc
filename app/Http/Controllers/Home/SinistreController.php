<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Sinistre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SinistreController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
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

        $data = $request->only(['nom_complet', 'type_sinistre', 'contact', 'description', 'latitude', 'longitude', 'lieu']);

        // Stockage des images
        if ($request->hasFile('image1')) {
            $data['image1'] = $request->file('image1')->store('sinistres', 'public');
        }
        if ($request->hasFile('image2')) {
            $data['image2'] = $request->file('image2')->store('sinistres', 'public');
        }
        if ($request->hasFile('image3')) {
            $data['image3'] = $request->file('image3')->store('sinistres', 'public');
        }

        // Création du sinistre
        $sinistre = Sinistre::create($data);

        // Recherche de la caserne la plus proche si la position est disponible
        if ($sinistre->latitude && $sinistre->longitude) {
            $this->assignNearestCasernes($sinistre);
        }

        return back()->with('success', 'Votre déclaration a été enregistrée avec succès. Les secours ont été informés.');
    }

    /**
     * Calcule et assigne la caserne la plus proche via la formule Haversine
     */
    private function assignNearestCasernes(Sinistre $sinistre)
    {
        $lat = $sinistre->latitude;
        $lng = $sinistre->longitude;

        // On récupère toutes les casernes actives
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

        // Tri par distance (croissant)
        usort($distances, function($a, $b) {
            return $a['distance'] <=> $b['distance'];
        });

        // On prend la première (la plus proche)
        $nearest = array_slice($distances, 0, 1);

        foreach ($nearest as $item) {
            $sinistre->casernes()->attach($item['id'], ['distance' => $item['distance']]);
        }
    }

    /**
     * Formule de Haversine pour calculer la distance entre deux points (en KM)
     */
    private function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
    {
        // convert from degrees to radians
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
