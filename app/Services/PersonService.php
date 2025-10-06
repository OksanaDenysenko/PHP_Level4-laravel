<?php

namespace App\Services;

use App\Enums\SwapiDataType;
use App\Repository\PersonRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class PersonService
{
    protected array $relationshipKeys = [
        'film_ids'=>'films',
        'vehicle_ids'=>'vehicles',
        'starship_ids'=>'starships'];

    public function __construct(protected PersonRepository $personRepository)
    {
    }

    /**
     * The method gets a paginated list of characters to display on the page.
     */
    public function getPaginatedPeople(): LengthAwarePaginator
    {
        return $this->personRepository->getPaginatedPeopleWithRelations();
    }

    /**
     * The method creates a new character with all its relations
     * @param array $data
     * @return Model|null
     */
    public function createPerson(array $data): ?Model
    {
        $personData = array_diff_key($data, $this->relationshipKeys);
        $person = $this->personRepository->create($personData);

        if ($person) {
            $rawRelationshipsData = array_intersect_key($data, $this->relationshipKeys);
            $relationshipsData=[];

            foreach ($rawRelationshipsData as $oldKey => $value) {

                if (isset($this->relationshipKeys[$oldKey])) {
                    $newKey = $this->relationshipKeys[$oldKey];
                    $relationshipsData[$newKey] = $value;
                }
            }

            if(!empty($relationshipsData)){
            $this->personRepository->syncRelationships($person, $relationshipsData);
            }
        }

        return $person;
    }

    /**
     * The method collects all the necessary data for the form
     * @return array
     */
    public function getDataForCreationForm(): array
    {
        $lookups = [
            'planets' => 'name',
            'species' => 'name',
            'films' => 'title',
            'vehicles' => 'name',
            'starships' => 'name',
        ];
        $options = [];

        foreach ($lookups as $dataType => $nameColumn) {
            $dataTypeObject = SwapiDataType::from($dataType);
            $repository = $dataTypeObject->getRepository();
            $options[$dataType] = $repository->getColumns(['id', $nameColumn]);
        }

        $options['genders'] = ['male', 'female', 'n/a', 'hermaphrodite'];

        return $options;
    }
}
