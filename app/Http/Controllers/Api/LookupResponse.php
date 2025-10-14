<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;

trait LookupResponse
{
    /**
     * The method receives lookups and returns it in JSON format.
     * @return JsonResponse
     */
    public function getLookups(): JsonResponse
    {
        return response()->json($this->service->fetchSwapiLookups());
    }
}
