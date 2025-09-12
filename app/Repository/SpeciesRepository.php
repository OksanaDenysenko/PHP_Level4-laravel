<?php

namespace App\Repository;

use App\Models\Species;

class SpeciesRepository extends Repository
{
    protected string $model {
        get {
            return Species::class;
        }
    }
}
