<?php

namespace App\Repository;

use App\Models\Species;

class SpeciesRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(Species::class);
    }
}
