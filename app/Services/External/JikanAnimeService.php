<?php

namespace App\Services\External;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JikanAnimeService
{
    protected string $baseUrl = 'https://api.jikan.moe/v4';

    public function find(string $animeName)
    {
        $animeName = trim($animeName);

        if ($animeName === '') {
            return null;
        }

        return Cache::remember('jikan.anime.' . md5($animeName), now()->addHours(6), function () use ($animeName) {
            try {
                $searchResponse = Http::timeout(10)
                    ->acceptJson()
                    ->get("{$this->baseUrl}/anime", [
                        'q' => $animeName,
                        'limit' => 1,
                    ]);

                if ($searchResponse->failed()) {
                    Log::warning('Jikan API search returned error status: ' . $searchResponse->status());
                    return null;
                }

                $searchData = $searchResponse->json();
                $animeId = data_get($searchData, 'data.0.mal_id');

                if (!$animeId) {
                    Log::warning("Jikan API did not find anime: {$animeName}");
                    return null;
                }

                return $this->findById($animeId);
            } catch (\Throwable $th) {
                Log::error('JikanAnimeService Error: ' . $th->getMessage());
                return null;
            }
        });
    }

    public function findById(int $animeId)
    {
        try {
            $response = Http::timeout(10)
                ->acceptJson()
                ->get("{$this->baseUrl}/anime/{$animeId}/full");

            if ($response->failed()) {
                Log::warning('Jikan API returned error status: ' . $response->status());
                return null;
            }

            $data = $response->json();

            if (!isset($data['data'])) {
                Log::warning('Jikan API returned unexpected data format');
                return null;
            }

            return $data['data'];
        } catch (\Throwable $th) {
            Log::error('JikanAnimeService Error: ' . $th->getMessage());
            return null;
        }
    }
}
