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
        'structure_id',
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
}
