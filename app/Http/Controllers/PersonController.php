<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Models\Person;
use App\Services\PersonService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PersonController extends Controller
{
    public function __construct(protected PersonService $personService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Factory|View|JsonResponse
    {
        $people = $this->personService->getPaginatedPeople();

        if ($request->ajax()) {

            return response()->json($people);
        }

        return view('people', compact('people'));
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
     * Display the specified resource.
     */
    public function show(Person $person)
    {
        //
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
