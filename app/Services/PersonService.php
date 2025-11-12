<?php

namespace App\Services;

use App\DTO\People\CreatePersonDTO;
use App\Repository\PersonRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class PersonService
{
    use SwapiLookups;

    protected array $relationships = ['films', 'vehicles', 'starships'];

    public function __construct(protected PersonRepository $repository)
    {
    }

    /**
     * The method gets a paginated list of characters to display on the page.
     */
    public function getPaginatedPeople($request): LengthAwarePaginator
    {
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 10);

        return $this->repository->getPaginatedPeopleWithRelations($page, $perPage);
    }

    /**
     * The method creates a new character with all its relations
     * @param CreatePersonDTO $dto
     * @return Model|null
     */
    public function createPerson(CreatePersonDTO $dto): ?Model
    {
        $data=$dto->toArray();
        $personData = array_diff_key($data, $this->relationships);
        Log::info("this is relationship:",$personData);
        $person = $this->repository->create($personData);

        if ($person) {
            Log::info('yes');
            $relationshipsData = array_intersect_key($data, $this->relationships);
            Log::info("this is relationship:",$relationshipsData);
            if (!empty($relationshipsData)) {
                $this->repository->syncRelationships($person, $relationshipsData);
            }

            $person->load(['planet', 'species', 'films', 'vehicles', 'starships']);
        }

        return $person;
    }
}
