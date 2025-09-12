<?php

namespace App\Repository;

use App\Models\Starship;

class StarshipRepository extends Repository
{
    protected string $model {
        get {
            return Starship::class;
        }
    }
}
