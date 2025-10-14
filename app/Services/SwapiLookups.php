<?php

namespace App\Services;

use App\Repository\FilmRepository;

trait SwapiLookups
{
    /**
     * The method fetches lookups
     * @return array
     */
    public function fetchSwapiLookups(): array
    {
        $nameColumn = ($this->repository instanceof FilmRepository) ? 'title' : 'name';

        return $this->repository->getColumns(['id', $nameColumn])->toArray();
    }
}
