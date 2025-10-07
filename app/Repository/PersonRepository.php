<?php

namespace App\Repository;

use App\Models\Person;
use Illuminate\Pagination\LengthAwarePaginator;

class PersonRepository extends Repository
{
    protected string $model = Person::class;

    /**
     * The method gets a paginated list of characters with all bindings sorted by creation date.
     */
    public function getPaginatedPeopleWithRelations($page,$perPage): LengthAwarePaginator
    {
        $columns = ['id', 'name', 'height', 'mass', 'hair_color', 'skin_color', 'eye_color',
            'birth_year', 'gender', 'planet_id', 'species_id', 'created_at'];

        return Person::with(['planet', 'species', 'films', 'vehicles', 'starships'])
            ->latest('created_at')
            ->paginate($perPage,$columns,'page',$page);
    }
}
