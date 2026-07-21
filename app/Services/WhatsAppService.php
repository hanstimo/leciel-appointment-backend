<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public static function send(string $phone, string $message): void
    {
        $token = config('services.fonnte.token');

        if (! $token) {
            Log::warning('Fonnte token is not set, WhatsApp message was not sent.');
            return;
        }

        try {
            Http::withHeaders(['Authorization' => $token])
                ->asForm()
                ->post('https://api.fonnte.com/send', [
                    'target' => self::normalizePhone($phone),
                    'message' => $message,
                ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send WhatsApp message: ' . $e->getMessage());
        }
    }

    protected static function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        return $phone;
    }
}