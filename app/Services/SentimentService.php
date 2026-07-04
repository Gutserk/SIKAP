<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SentimentService
{
    protected $apiUrl;
    protected $apiToken;
    protected $threshold = 0.75;

    protected $labelMap = [
        'LABEL_0' => 'Positif',
        'LABEL_1' => 'Netral',
        'LABEL_2' => 'Negatif',
    ];

    public function __construct()
    {
        $this->apiUrl   = env('HF_API_URL');
        $this->apiToken = env('HF_API_TOKEN');
    }

    public function analyze(string $text): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Content-Type'  => 'application/json',
            ])->timeout(30)->post($this->apiUrl, [
                'inputs' => $text,
            ]);

            if (!$response->successful()) {
                Log::error('HuggingFace API error: ' . $response->body());
                return ['sentiment' => null, 'confidence' => null];
            }

            $results = $response->json()[0]; // array of {label, score}

            // Ambil skor tertinggi
            $best = collect($results)->sortByDesc('score')->first();

            // Terapkan threshold
            if ($best['score'] < $this->threshold) {
                $sentiment = 'Netral';
            } else {
                $sentiment = $this->labelMap[$best['label']] ?? $best['label'];
            }

            return [
                'sentiment'  => $sentiment,
                'confidence' => round($best['score'], 4),
            ];

        } catch (\Exception $e) {
            Log::error('Sentiment analysis failed: ' . $e->getMessage());
            return ['sentiment' => null, 'confidence' => null];
        }
    }
}