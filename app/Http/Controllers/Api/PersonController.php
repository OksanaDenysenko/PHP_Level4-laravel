<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Models\Person;
use App\Services\PersonService;
use Illuminate\Http\JsonResponse;

class PersonController extends Controller
{
    public function __construct(protected PersonService $personService)
    {
    }

    /**
     * The method is responsible for passing data for the form.
     * @return JsonResponse
     */
    public function getFormOptions(): JsonResponse
    {
        return response()->json($this->personService->getDataForCreationForm());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonRequest $request): JsonResponse
    {
        $person = $this->personService->createPerson($request->validated());

        return response()->json($person, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonRequest $request, Person $person)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        //
    }
}
