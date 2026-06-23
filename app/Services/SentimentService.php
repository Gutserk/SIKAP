<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SentimentService
{
    /**
     * Analyze text sentiment via the Flask IndoBERT API.
     *
     * Returns null on any failure (API down, timeout, unexpected response)
     * so callers can safely ignore sentiment without breaking their flow.
     *
     * @return array{sentimen: string, skor: float}|null
     */
    public function analyze(string $text): ?array
    {
        try {
            $response = Http::timeout(5)->post(config('services.sentiment.url'), [
                'text' => $text,
            ]);

            if (!$response->successful()) {
                Log::warning('Sentiment API returned a non-successful response', [
                    'status' => $response->status(),
                ]);
                return null;
            }

            $data = $response->json();

            if (!isset($data['sentiment'], $data['confidence'])) {
                Log::warning('Sentiment API response missing expected fields', ['data' => $data]);
                return null;
            }

            return [
                'sentimen' => strtolower($data['sentiment']),
                'skor'     => $data['confidence'],
            ];
        } catch (\Throwable $e) {
            Log::warning('Sentiment API call failed', ['message' => $e->getMessage()]);
            return null;
        }
    }
}
