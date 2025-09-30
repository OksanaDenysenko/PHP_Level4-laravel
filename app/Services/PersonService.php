<?php

namespace App\Services;

use App\Enums\SwapiDataType;
use App\Repository\PersonRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class PersonService
{
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

    public function createPerson(array $data)
    {


       // return $this->personRepository->create($data);

    }

    /**
     * The method collects all the necessary data for the form
     * @return array
     */
    public function getDataForCreationForm(): array
    {
        $lookups=['planets','species', 'films', 'vehicles', 'starships'];
        $options=[];

        foreach ($lookups as $dataType){
            $dataTypeObject = SwapiDataType::from($dataType);
            $repository = $dataTypeObject->getRepository();
            $options[$dataType]=$repository->getColumns(['id', 'name']);
        }

        return $options;
    }
}
