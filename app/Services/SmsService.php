<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Envoie un SMS via l'API Yellika (1smsafrica)
     */
    public static function send($to, $message)
    {
        $apiUrl = env('YELLIKA_API_URL') . 'sms/send';
        $apiKey = env('YELLIKA_API_KEY');
        $senderId = env('YELLIKA_SENDER_ID');

        // Nettoyage du numéro (supprimer les espaces, etc.)
        $to = str_replace(' ', '', $to);
        
        // S'assurer que le numéro commence par un code pays (ex: 225 pour la CI)
        // Si le numéro fait 10 chiffres (nouveau format CI), on ajoute 225
        if (strlen($to) == 10) {
            $to = '225' . $to;
        }

        try {
            $response = Http::withToken($apiKey)
                ->post($apiUrl, [
                    'recipient' => $to,
                    'sender_id' => $senderId,
                    'message'   => $message,
                    'type'      => 'plain',
                ]);

            if ($response->successful()) {
                Log::info("SMS envoyé avec succès à $to");
                return true;
            }

            Log::error("Erreur lors de l'envoi du SMS à $to : " . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error("Exception lors de l'envoi du SMS : " . $e->getMessage());
            return false;
        }
    }
}
