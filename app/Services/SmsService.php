<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Convertit le texte en ASCII (sans accents) pour les passerelles SMS
     * qui ne supportent pas l'UNICODE.
     */
    private static function toAsciiMessage(string $message): string
    {
        $normalized = str_replace(["’", "`"], "'", $message);

        $ascii = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $normalized);
        if ($ascii === false) {
            $ascii = $normalized;
        }

        // Supprime tout caractere non imprimable ASCII restant.
        $ascii = preg_replace('/[^\x20-\x7E]/', '', $ascii) ?? '';

        // Nettoyage final des espaces.
        $ascii = trim(preg_replace('/\s+/', ' ', $ascii) ?? '');

        return $ascii;
    }

    /**
     * Envoie un SMS via l'API Yellika (1smsafrica)
     */
    public static function send($to, $message)
    {
        $baseUrl = (string) config('services.yellika.base_url');
        $apiKey = (string) config('services.yellika.api_key');
        $senderId = (string) config('services.yellika.sender_id');
        $apiUrl = rtrim($baseUrl, '/') . '/sms/send';

        if ($baseUrl === '' || $apiKey === '' || $senderId === '') {
            Log::error("Configuration SMS incomplète (YELLIKA_API_URL / YELLIKA_API_KEY / YELLIKA_SENDER_ID).");
            return false;
        }

        // Nettoyage du numéro (supprimer les espaces, etc.)
        $to = str_replace(' ', '', $to);

        // S'assurer que le numéro commence par un code pays (ex: 225 pour la CI)
        // Si le numéro fait 10 chiffres (nouveau format CI), on ajoute 225
        if (strlen($to) == 10) {
            $to = '225' . $to;
        }

        $message = self::toAsciiMessage((string) $message);

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
