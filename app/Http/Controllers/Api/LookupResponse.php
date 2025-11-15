<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait LookupResponse
{
    /**
     * The method receives lookups and returns it in JSON format.
     * @param Request $request
     * @return JsonResponse
     */
    public function getLookups(Request $request): JsonResponse
    {
        return response()->json($this->service->filterSwapiLookups($request->query()));
    }
}
