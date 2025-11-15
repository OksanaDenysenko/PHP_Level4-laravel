<?php

namespace App\Services;

use App\Repository\SpeciesRepository;

class SpeciesService
{
    use SwapiLookups;

    public function __construct(protected SpeciesRepository $repository)
    {
    }
}
