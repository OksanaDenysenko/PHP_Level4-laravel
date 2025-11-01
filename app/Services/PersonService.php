<?php

namespace App\Services;

use App\DTO\People\CreatePersonDTO;
use App\Repository\PersonRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class PersonService
{
    use SwapiLookups;

    protected array $relationshipKeys = [
        'film_ids' => 'films',
        'vehicle_ids' => 'vehicles',
        'starship_ids' => 'starships'];

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
        $personData = array_diff_key($data, $this->relationshipKeys);
        $person = $this->repository->create($personData);

        if ($person) {
            $rawRelationshipsData = array_intersect_key($data, $this->relationshipKeys);
            $relationshipsData = [];

            foreach ($rawRelationshipsData as $oldKey => $value) {

                if (isset($this->relationshipKeys[$oldKey])) {
                    $newKey = $this->relationshipKeys[$oldKey];
                    $relationshipsData[$newKey] = $value;
                }
            }

            if (!empty($relationshipsData)) {
                $this->repository->syncRelationships($person, $relationshipsData);
            }

            $person->load(['planet', 'species', 'films', 'vehicles', 'starships']);
        }

        return $person;
    }
}
