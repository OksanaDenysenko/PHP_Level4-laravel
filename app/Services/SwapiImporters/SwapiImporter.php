<?php

namespace App\Services\SwapiImporters;

use App\Enums\SwapiDataType;
use App\Repository\Repository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

abstract class SwapiImporter
{
    protected array $repositories = [];

    abstract protected array $relationsMap {
        get;
    }

    abstract protected SwapiDataType $dataType {
        get;
    }

    /**
     *The method returns prepared data for import of the corresponding data type
     * @param array $item
     * @return array
     */
    abstract protected function preparedData(array $item): array;

    /**
     *  The method performs the general process of importing data from SWAPI into the database
     * @param array $data
     * @return void
     */
    final public function import(array $data): void
    {
        foreach ($data as $item) {
            $repository= $this->getRepository($this->dataType);
            $model = $repository->create($this->preparedData($item));

            if ($model && !empty($this->relationsMap)) {
                $this->syncRelationships($model, $item, $this->relationsMap);
            }
        }
    }

    /**
     * The method returns the required repository for the corresponding data type
     * @param SwapiDataType $dataType
     * @return Repository
     */
    protected function getRepository(SwapiDataType $dataType): Repository
    {
        if (!isset($this->repositories[$dataType->value])) {
            $this->repositories[$dataType->value] = $dataType->getRepository();
        }

        return $this->repositories[$dataType->value];
    }

//    /**
//     *  The method creates a repository object based on the data type
//     * @param string $dataType
//     * @return FilmRepository|PersonRepository|PlanetRepository|SpeciesRepository|StarshipRepository|VehicleRepository|null
//     */
//    protected function createRepository(SwapiDataType $dataType): FilmRepository|PlanetRepository|SpeciesRepository|StarshipRepository|VehicleRepository|PersonRepository|null
//    {
//        return match ($dataType) {
//            'films' => new FilmRepository(),
//            'people' => new PersonRepository(),
//            'planets' => new PlanetRepository(),
//            'species' => new SpeciesRepository(),
//            'starships' => new StarshipRepository(),
//            'vehicles' => new VehicleRepository(),
//            default => null,
//        };
//    }

    /**
     * The method returns fields that are common to all data types
     * @param array $item
     * @return array
     */
    protected function prepareBaseData(array $item): array
    {
        return [
            'external_id' => basename(rtrim($item['url'], '/')),
            'created' => Carbon::parse($item['created'])->format('Y-m-d H:i:s.u'),
            'edited' => Carbon::parse($item['edited'])->format('Y-m-d H:i:s.u'),
            'url' => $item['url'],
        ];
    }

    /**
     * The method checks whether the value is numeric, and if not, replaces it with NULL.
     * @param $value
     * @return float|int|null
     */
    protected function getNumericOrNull($value): float|int|null
    {
        return is_numeric($value) ? $value : null;
    }

    /**
     *  The method synchronizes many-to-many relationships for the newly created model
     * @param Model $model
     * @param array $item
     * @param array $relationsMap
     * @return void
     */
    protected function syncRelationships(Model $model, array $item, array $relationsMap): void
    {
        foreach ($relationsMap as $relationName) {

            if (isset($item[$relationName]) && is_array($item[$relationName])) {
                $externalIds = collect($item[$relationName])->map(fn($url) => basename(rtrim($url, '/')))->all();
                $relatedRepository = $this->getRepository(SwapiDataType::from($relationName));
                $localIds = $relatedRepository->getIdsByExternalIds($externalIds);
                $filteredLocalIds = array_filter($localIds);
                $model->{$relationName}()->sync($filteredLocalIds);
            }
        }
    }

    /**
     * The method looks up the local ID in the database by the ID from the URL
     * @param string|null $url
     * @param string $dataType
     * @return int|null
     */
    protected function getOneToManyRelationId(?string $url, SwapiDataType $dataType): ?int
    {
        if (!empty($url)) {
            $externalId = basename(rtrim($url, '/'));
            $relatedRepository = $this->getRepository($dataType);

            return $relatedRepository->getIdByExternalId($externalId);
        }

        return null;
    }
}
