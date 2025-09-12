<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SwapiApiService
{
    protected string $baseUrl;
    public function __construct()
    {
        $this->baseUrl=config('swapi.url');
    }

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

    /**
     * The method gets a list of all available endpoints from the base URL.
     * @return array
     * @throws \Exception
     */
    public function getEndpoints(): array
    {
        return $this->getPage($this->baseUrl);
    }
}
