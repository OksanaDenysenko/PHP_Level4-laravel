<?php

namespace App\Repository;

use App\Models\Person;
use Illuminate\Pagination\LengthAwarePaginator;

class PersonRepository extends Repository
{
    protected string $model = Person::class;

    /**
     *
     * The method gets a paginated list of characters with all bindings sorted by creation date.
     */
    public function getPaginatedPeopleWithRelations($perPage): LengthAwarePaginator
    {
        return Person::with(['planet', 'species', 'films', 'vehicles', 'starships'])
            ->latest('created_at')
            ->paginate($perPage);
    }
}
