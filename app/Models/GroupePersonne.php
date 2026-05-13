<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupePersonne extends Model
{
    protected $fillable = [
        'groupe_id',
        'nom_complet',
        'telephone',
        'fonction',
        'archived_at',
    ];

    protected $casts = [
        'archived_at' => 'datetime',
    ];

    public function groupe()
    {
        return $this->belongsTo(User::class, 'groupe_id');
    }
}
