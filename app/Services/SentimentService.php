<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SentimentService
{
    protected $apiUrl;
    protected $threshold = 0.75;

    public function __construct()
    {
        $this->apiUrl = env('SENTIMENT_API_URL');
    }

    /**
     * Analyze text sentiment via the external sentiment API.
     *
     * Returns null on any failure (API down, timeout, unexpected response)
     * so callers can safely ignore sentiment without breaking their flow.
     *
     * @return array{sentimen: string, skor: float}|null
     */
    public function analyze(string $text): ?array
    {
        try {
            $response = Http::timeout(30)->post($this->apiUrl, [
                'text' => $text,
            ]);

            if (!$response->successful()) {
                return null;
            }

            $data = $response->json();

            if (!isset($data['sentiment'], $data['confidence'])) {
                return null;
            }

            $sentimen = $data['confidence'] < $this->threshold ? 'Netral' : $data['sentiment'];

            return [
                'sentimen' => $sentimen,
                'skor'     => $data['confidence'],
            ];
        } catch (\Exception) {
            return null;
        }
    }
}