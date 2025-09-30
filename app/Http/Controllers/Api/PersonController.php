<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PersonService;
use Illuminate\Http\JsonResponse;

class PersonController extends Controller
{
    /**
     * The method is responsible for passing data for the form.
     * @param PersonService $personService
     * @return JsonResponse
     */
    public function getFormOptions(PersonService $personService): JsonResponse
    {
        return response()->json($personService->getDataForCreationForm());
    }
}
