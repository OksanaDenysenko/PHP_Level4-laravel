<?php

namespace App\Repository;

use App\Models\Planet;

class PlanetRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(Planet::class);
    }
}
