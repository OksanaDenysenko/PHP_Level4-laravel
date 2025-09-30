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
    public function store(StorePersonRequest $request)
    {
        dump($request);
        dump($request->all());
        // Передаємо валідовані дані до сервісу
//        $person = $this->personService->createPerson($request->validated());
//
//        // Повертаємо успішну відповідь
//        return response()->json($person, 201); // 201 Created
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
