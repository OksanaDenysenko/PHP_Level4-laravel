<?php

namespace App\Services;

use App\Repository\VehicleRepository;

class VehicleService
{
    use SwapiLookups;

    public function __construct(protected VehicleRepository $repository)
    {
    }
}
