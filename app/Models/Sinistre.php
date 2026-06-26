<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sinistre extends Model
{
    protected $fillable = [
        'nom_complet',
        'type_sinistre',
        'contact',
        'description',
        'image1',
        'image2',
        'image3',
        'latitude',
        'longitude',
        'lieu',
        'status', // Ex: 'en_attente', 'en_cours', 'resolu', 'termine'
        'assigned_caserne_id',
        'rapport_intervention',
        'date_cloture',
        'reference',
        'nb_morts',
        'nb_blesses',
        'nb_evacues',
        'etat_des_lieux_documents',
        'structure_id',
        'declarations_count',
    ];

    protected $casts = [
        'date_cloture' => 'datetime',
        'etat_des_lieux_documents' => 'array',
    ];

    protected $attributes = [
        'declarations_count' => 1,
    ];

    protected static function booted()
    {
        static::creating(function ($sinistre) {
            $date = now()->format('Ymd');
            $count = static::whereDate('created_at', today())->count() + 1;
            $sinistre->reference = 'SN-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        });
    }

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }

    public function caserneAssignee()
    {
        return $this->belongsTo(User::class, 'assigned_caserne_id');
    }

    public function casernes()
    {
        return $this->belongsToMany(User::class, 'sinistre_caserne')
            ->withPivot('distance')
            ->withTimestamps();
    }

    public function getCaserneOrGroupAttribute()
    {
        return $this->caserneAssignee ?? $this->casernes->first();
    }

    public static function createOrMerge(array $data)
    {
        $lat = isset($data['latitude']) ? (float) $data['latitude'] : null;
        $lng = isset($data['longitude']) ? (float) $data['longitude'] : null;
        $type = $data['type_sinistre'] ?? null;

        if ($lat && $lng && $type) {
            // Trouver les sinistres actifs du même type
            $activeSinistres = self::where('type_sinistre', $type)
                ->whereIn('status', ['en_attente', 'en_cours'])
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get();

            foreach ($activeSinistres as $s) {
                // Distance en kilomètres
                $distance = self::calculateDistance($lat, $lng, (float)$s->latitude, (float)$s->longitude);

                // Si la distance est de 30 mètres (0.03 km) ou moins
                if ($distance <= 0.03) {
                    $newDesc = $s->description . "\n\n[Signalement supplémentaire - " . now()->format('d/m/Y H:i') . " par " . ($data['nom_complet'] ?? 'Anonyme') . " (" . ($data['contact'] ?? 'N/A') . ")] : " . ($data['description'] ?? '');

                    $s->update([
                        'declarations_count' => $s->declarations_count + 1,
                        'description' => $newDesc,
                    ]);

                    return $s;
                }
            }
        }

        // Sinon, créer un nouveau sinistre
        return self::create($data);
    }

    private static function calculateDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) ** 2
           + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;

        return $earthRadius * 2 * asin(sqrt($a));
    }
}
