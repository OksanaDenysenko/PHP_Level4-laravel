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
    public function getPaginatedPeople(): LengthAwarePaginator
    {
        return $this->personRepository->getPaginatedPeopleWithRelations();
    }
}
