<?php

namespace App\Repository;

use App\Models\Film;

class FilmRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(Film::class);
    }
}
