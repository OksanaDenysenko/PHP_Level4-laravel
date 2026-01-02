<?php

namespace App\Http\Controllers\Api;

use App\DTO\People\CreatePersonDTO;
use App\DTO\People\UpdatePersonDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Models\Person;
use App\Services\PersonService;
use Illuminate\Http\JsonResponse;

class PersonController extends Controller
{
    use LookupResponse;
    public function __construct(protected PersonService $service)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonRequest $request): JsonResponse
    {
        $dto = CreatePersonDTO::fromArray($request->validated());
        $person = $this->service->createPerson($dto);

        return response()->json($person, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonRequest $request, Person $person): JsonResponse
    {
        $dto = UpdatePersonDTO::fromArray($request->validated());
        $updatedPerson = $this->service->updatePerson($person, $dto);

        return response()->json($updatedPerson, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        //
    }
}
