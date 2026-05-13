<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'prenom', 'email', 'password', 'role', 'status', 'telephone', 'logo', 'commune', 'adresse', 'latitude', 'longitude', 'otp_code', 'ville', 'caserne_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function sinistresAssignes()
    {
        return $this->belongsToMany(Sinistre::class, 'sinistre_caserne')
            ->withPivot('distance')
            ->withTimestamps();
    }

    public function caserneParent()
    {
        return $this->belongsTo(User::class, 'caserne_id');
    }

    public function groupes()
    {
        return $this->hasMany(User::class, 'caserne_id')->where('role', 'groupe');
    }

    public function personnesDuGroupe()
    {
        return $this->hasMany(GroupePersonne::class, 'groupe_id');
    }
}
