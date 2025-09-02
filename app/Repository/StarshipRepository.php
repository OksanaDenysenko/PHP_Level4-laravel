<?php

namespace App\Repository;

use App\Models\Starship;

class StarshipRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(Starship::class);
    }
}
