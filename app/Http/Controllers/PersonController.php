<?php

namespace App\Http\Controllers;

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
        $people = $this->personService->getPaginatedPeople($request);

        if ($request->ajax()) {

            return response()->json($people);
        }

        return view('people', compact('people'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {
        //
    }
}
