<?php

namespace App\Services;

use App\Repository\PlanetRepository;

class PlanetService
{
    use SwapiLookups;

    public function __construct(protected PlanetRepository $repository)
    {
    }
}
