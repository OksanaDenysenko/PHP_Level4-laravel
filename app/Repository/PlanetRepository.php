<?php

namespace App\Repository;

use App\Models\Planet;

class PlanetRepository extends Repository
{
    protected string $model {
        get {
            return Planet::class;
        }
    }
}
