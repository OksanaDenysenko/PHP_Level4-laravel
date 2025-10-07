<?php

namespace App\Services;

use App\Repository\PersonRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class PersonService
{
    public function __construct(protected PersonRepository $personRepository)
    {
    }

    /**
     * The method gets a paginated list of characters to display on the page.
     */
    public function getPaginatedPeople($request): LengthAwarePaginator
    {
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 10);

        return $this->personRepository->getPaginatedPeopleWithRelations($page,$perPage);
    }
}
