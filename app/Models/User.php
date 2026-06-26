<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'prenom', 'email', 'password', 'role', 'status', 'telephone', 'logo', 'commune', 'adresse', 'latitude', 'longitude', 'otp_code', 'ville', 'caserne_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Resolve hyphenated names from URL to spaces in DB
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if ($field === 'name') {
            $realName = str_replace('-', ' ', $value);
            $user = $this->where('name', $realName)->first();

            if (!$user) {
                $user = $this->where('name', $value)->first();
            }

            if (!$user) {
                $cleanValue = str_replace([' ', '-'], '', strtolower($value));
                $user = $this->whereRaw("LOWER(REPLACE(REPLACE(name, '-', ''), ' ', '')) = ?", [$cleanValue])->first();
            }

            if (!$user) {
                // Recherche par comparaison de slug (très robuste pour les caractères spéciaux comme les slashs)
                $user = $this->get()->first(function ($u) use ($value) {
                    return \Illuminate\Support\Str::slug($u->name) === $value;
                });
            }

            if (!$user) {
                abort(404);
            }

            return $user;
        }

        return parent::resolveRouteBinding($value, $field);
    }

    /**
     * Get name formatted for URL (spaces to hyphens, slugged)
     */
    public function getUrlNameAttribute()
    {
        return \Illuminate\Support\Str::slug($this->name);
    }

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
