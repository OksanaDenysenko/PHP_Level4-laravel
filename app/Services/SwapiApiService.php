<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SwapiApiService
{
    /**
     * The method sends a GET request to $url and returns a response.
     * @param string $url
     * @return array
     * @throws \Exception
     */
    public function getPage(string $url): array
    {
        $response = Http::get($url);

        if ($response->failed()) {
            throw new \Exception("Invalid API response format.");
        }

        return $response->json();
    }
}
