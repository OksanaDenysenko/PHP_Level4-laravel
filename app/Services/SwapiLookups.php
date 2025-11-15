<?php

namespace App\Services;

use App\Repository\FilmRepository;

trait SwapiLookups
{
    /**
     * The method filters records based on the provided criteria
     * @param array $filters
     * @return array
     */
    public function filterSwapiLookups(array $filters=[]): array
    {
        $nameColumn = ($this->repository instanceof FilmRepository) ? 'title' : 'name';

        return $this->repository->getByFilter($filters, ['id',$nameColumn]);
    }
}
