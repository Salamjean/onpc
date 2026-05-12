<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Structure extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nom',
        'contact',
        'email',
        'adresse',
        'commune',
        'ville',
        'password',
        'otp_code',
        'status',
        'latitude',
        'longitude'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Envoyer la notification de réinitialisation de mot de passe.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $url = route('structure.auth.password.reset', [
            'token' => $token,
            'email' => $this->email
        ]);

        $this->notify(new \Illuminate\Auth\Notifications\ResetPassword($token));
        
        // Note: Pour que cela utilise exactement l'URL ci-dessus, 
        // nous pourrions créer une notification personnalisée, 
        // mais voyons d'abord si la route par défaut peut être "mappée".
    }
}
