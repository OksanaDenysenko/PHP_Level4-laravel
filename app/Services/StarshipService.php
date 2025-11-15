<?php

namespace App\Services;

use App\Repository\StarshipRepository;

class StarshipService
{
    use SwapiLookups;

    public function __construct(protected StarshipRepository $repository)
    {
    }
}
