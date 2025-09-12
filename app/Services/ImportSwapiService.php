<?php

namespace App\Services;

use App\Services\SwapiImporters\FilmImporter;
use App\Services\SwapiImporters\PersonImporter;
use App\Services\SwapiImporters\PlanetImporter;
use App\Services\SwapiImporters\SpeciesImporter;
use App\Services\SwapiImporters\StarshipImporter;
use App\Services\SwapiImporters\VehicleImporter;

class ImportSwapiService
{
    protected array $importers = [];

    /**
     * The method performs the general process of importing data from SWAPI into the database
     * @param string $dataType
     * @param array $data
     * @return void
     */
    public function importData(string $dataType, array $data): void
    {
        if (!isset($this->importers[$dataType])) {
            $this->importers[$dataType] = $this->createImporter($dataType);
        }

        $importer = $this->importers[$dataType] ?? null;

        if (!$importer) {
            throw new \InvalidArgumentException("Unknown data type: '{$dataType}'");
        }
        $importer->import($data);
    }

    /**
     * The method creates an importer object based on the data type
     * @param string $dataType
     * @return PersonImporter|StarshipImporter|VehicleImporter|FilmImporter|PlanetImporter|SpeciesImporter|null
     */
    protected function createImporter(string $dataType): PersonImporter|StarshipImporter|VehicleImporter|FilmImporter|PlanetImporter|SpeciesImporter|null
    {
        return match ($dataType) {
            'films' => new FilmImporter(),
            'people' => new PersonImporter(),
            'planets' => new PlanetImporter(),
            'species' => new SpeciesImporter(),
            'starships' => new StarshipImporter(),
            'vehicles' => new VehicleImporter(),
            default => null,
        };
    }

//    protected array $repositories = [];
//
//    public function __construct(
//        protected FilmRepository     $filmRepository,
//        protected PersonRepository   $personRepository,
//        protected PlanetRepository   $planetRepository,
//        protected SpeciesRepository  $speciesRepository,
//        protected StarshipRepository $starshipRepository,
//        protected VehicleRepository  $vehicleRepository
//    )
//    {
//        $this->repositories = [
//            'films' => $filmRepository,
//            'people' => $personRepository,
//            'planets' => $planetRepository,
//            'species' => $speciesRepository,
//            'starships' => $starshipRepository,
//            'vehicles' => $vehicleRepository,
//        ];
//    }
//
//    /**
//     * The method performs the general process of importing data from SWAPI into the database
//     * @param string $dataType
//     * @param array $data
//     * @return void
//     */
//    public function importData(string $dataType, array $data): void
//    {
//        $repository = $this->repositories[$dataType];
//
//        foreach ($data as $item) {
//            $preparedData = $this->prepareImportData($dataType, $item);
//
//            if ($dataType === 'species' || $dataType === 'people') {
//                $preparedData += $this->getOneToManyRelations($dataType, $item);
//            }
//
//            $model = $repository->create($preparedData);
//
//            if ($model && ($dataType === 'films' || $dataType === 'people')) {
//                $this->syncRelationships($model,$dataType, $item);
//            }
//        }
//    }
//
//    /**
//     * The method synchronizes many-to-many relationships for the newly created model
//     * using data from an external API
//     * @param Model $model
//     * @param string $dataType
//     * @param mixed $item
//     * @return void
//     */
//    protected function syncRelationships(Model $model, string $dataType, mixed $item): void
//    {
//        $relationsMap = match ($dataType) {
//            'films' => ['species', 'vehicles', 'starships', 'planets'],
//            'people' => ['films', 'starships', 'vehicles'],
//            default => [],
//        };
//
//        foreach ($relationsMap as $relationName ) {
//
//            if (isset($item[$relationName]) && is_array($item[$relationName])) {
//                $externalIds = collect($item[$relationName])->map(fn($url) => basename(rtrim($url, '/')))->all();
//                $relatedRepository = $this->repositories[$relationName];
//                $localIds = $relatedRepository->getIdsByExternalIds($externalIds);
//                $model->{$relationName}()->sync($localIds);
//            }
//        }
//    }
//
//    /**
//     * The method finds and adds one-to-many foreign keys to the data array for import
//     * @param string $dataType
//     * @param array $item
//     * @return array
//     */
//    protected function getOneToManyRelations(string $dataType, array $item): array
//    {
//        $relationsData = [];
//
//        if (isset($item['homeworld'])) {
//            $homeworldExternalId = basename(rtrim($item['homeworld'], '/'));
//            $relationsData['planet_id'] = $this->repositories['planets']->getIdByExternalId($homeworldExternalId);
//        }
//
//        if ($dataType === 'people' && isset($item['species']) && count($item['species']) > 0) {
//            $speciesExternalId = basename(rtrim($item['species'][0], '/'));
//            $relationsData['species_id'] = $this->repositories['species']->getIdByExternalId($speciesExternalId);
//        }
//
//        return $relationsData;
//    }
//
//    /**
//     * The method prepares data for writing to the database.
//     * @param string $dataType
//     * @param array $item
//     * @return array
//     */
//    protected function prepareImportData(string $dataType, array $item): array
//    {
//        $preparedData = [
//            'external_id' => basename(rtrim($item['url'], '/')),
//            'created' => Carbon::parse($item['created'])->format('Y-m-d H:i:s.u'),
//            'edited' => Carbon::parse($item['edited'])->format('Y-m-d H:i:s.u'),
//            'url' => $item['url'],
//        ];
//
//        $numericFields = $this->getFieldsForNumericValidation($dataType);
//
//        foreach ($numericFields as $field) {
//            $preparedData[$field] = is_numeric($item[$field]) ? $item[$field] : null;
//        }
//
//        $otherFields = $this->getOtherFields($dataType);
//
//        foreach ($otherFields as $field) {
//
//            if (isset($item[$field])) {
//                $preparedData[$field] = $item[$field];
//            }
//        }
//
//        return $preparedData;
//    }
//
//    /**
//     * The method returns a list of fields to check for a numeric value for a specific data type.
//     * @param string $dataType
//     * @return array|string[]
//     */
//    protected function getFieldsForNumericValidation(string $dataType): array
//    {
//        return match ($dataType) {
//            'vehicles' => ['cost_in_credits', 'length', 'max_atmosphering_speed', 'crew', 'passengers', 'cargo_capacity'],
//            'starships' => ['cost_in_credits', 'length', 'max_atmosphering_speed', 'crew', 'passengers', 'cargo_capacity', 'hyperdrive_rating', 'MGLT'],
//            'planets' => ['rotation_period', 'orbital_period', 'diameter', 'surface_water', 'population'],
//            'species' => ['average_height', 'average_lifespan'],
//            'films' => ['episode_id'],
//            'people' => ['height', 'mass'],
//            default => [],
//        };
//    }
//
//    /**
//     * The method returns a list of fields to import that do not require special processing.
//     * @param string $dataType
//     * @return array|string[]
//     */
//    protected function getOtherFields(string $dataType): array
//    {
//        return match ($dataType) {
//            'vehicles' => ['name', 'model', 'manufacturer', 'consumables', 'vehicle_class'],
//            'starships' => ['name', 'model', 'manufacturer', 'consumables', 'starship_class'],
//            'planets' => ['name', 'climate', 'gravity', 'terrain'],
//            'species' => ['name', 'classification', 'designation', 'skin_colors', 'hair_colors', 'eye_colors', 'language', 'planet_id'],
//            'films' => ['title', 'opening_crawl', 'director', 'producer', 'release_date'],
//            'people' => ['name', 'hair_color', 'skin_color', 'eye_color', 'birth_year', 'gender', 'planet_id', 'species_id'],
//            default => [],
//        };
//    }
}
