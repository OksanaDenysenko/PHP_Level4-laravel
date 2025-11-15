<?php

namespace App\Services;

use App\Enums\SwapiDataType;
use App\Repository\FilmRepository;

class FilmService
{
    use SwapiLookups;

    public function __construct(protected FilmRepository $repository)
    {
    }
}
