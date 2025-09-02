<?php

namespace App\Services;

use App\Repository\FilmRepository;
use App\Repository\PersonRepository;
use App\Repository\PlanetRepository;
use App\Repository\SpeciesRepository;
use App\Repository\StarshipRepository;
use App\Repository\VehicleRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ImportSwapiService
{
    protected array $repositories = [];

    public function __construct(
        protected FilmRepository     $filmRepository,
        protected PersonRepository   $personRepository,
        protected PlanetRepository   $planetRepository,
        protected SpeciesRepository  $speciesRepository,
        protected StarshipRepository $starshipRepository,
        protected VehicleRepository  $vehicleRepository
    )
    {
        $this->repositories = [
            'films' => $filmRepository,
            'people' => $personRepository,
            'planets' => $planetRepository,
            'species' => $speciesRepository,
            'starships' => $starshipRepository,
            'vehicles' => $vehicleRepository,
        ];
    }

    /**
     * The method performs the general process of importing data from SWAPI into the database
     * @param string $dataType
     * @param array $data
     * @return void
     */
    public function importData(string $dataType, array $data): void
    {
        $repository = $this->repositories[$dataType];

        foreach ($data as $item) {
            $preparedData = $this->prepareImportData($dataType, $item);

            if ($dataType === 'species' || $dataType === 'people') {
                $preparedData += $this->getOneToManyRelations($dataType, $item);
            }

            $model = $repository->create($preparedData);

            if ($model && ($dataType === 'films' || $dataType === 'people')) {
                $this->syncRelationships($model,$dataType, $item);
            }
        }
    }

    /**
     * The method synchronizes many-to-many relationships for the newly created model
     * using data from an external API
     * @param Model $model
     * @param string $dataType
     * @param mixed $item
     * @return void
     */
    protected function syncRelationships(Model $model, string $dataType, mixed $item): void
    {
        $relationsMap = match ($dataType) {
            'films' => ['species', 'vehicles', 'starships', 'planets'],
            'people' => ['films', 'starships', 'vehicles'],
            default => [],
        };

        foreach ($relationsMap as $relationName ) {

            if (isset($item[$relationName]) && is_array($item[$relationName])) {
                $externalIds = collect($item[$relationName])->map(fn($url) => basename(rtrim($url, '/')))->all();
                $relatedRepository = $this->repositories[$relationName];
                $localIds = $relatedRepository->findIdsByExternalIds($externalIds);
                $model->{$relationName}()->sync($localIds);
            }
        }
    }

    /**
     * The method finds and adds one-to-many foreign keys to the data array for import
     * @param string $dataType
     * @param array $item
     * @return array
     */
    protected function getOneToManyRelations(string $dataType, array $item): array
    {
        $relationsData = [];

        if (isset($item['homeworld'])) {
            $homeworldExternalId = basename(rtrim($item['homeworld'], '/'));
            $relationsData['planet_id'] = $this->repositories['planets']->findIdByExternalId($homeworldExternalId);
        }

        if ($dataType === 'people' && isset($item['species']) && count($item['species']) > 0) {
            $speciesExternalId = basename(rtrim($item['species'][0], '/'));
            $relationsData['species_id'] = $this->repositories['species']->findIdByExternalId($speciesExternalId);
        }

        return $relationsData;
    }

    /**
     * The method prepares data for writing to the database.
     * @param string $dataType
     * @param array $item
     * @return array
     */
    protected function prepareImportData(string $dataType, array $item): array
    {
        $preparedData = [
            'external_id' => basename(rtrim($item['url'], '/')),
            'created' => Carbon::parse($item['created'])->format('Y-m-d H:i:s.u'),
            'edited' => Carbon::parse($item['edited'])->format('Y-m-d H:i:s.u'),
            'url' => $item['url'],
        ];

        $numericFields = $this->getFieldsForNumericValidation($dataType);

        foreach ($numericFields as $field) {
            $preparedData[$field] = is_numeric($item[$field]) ? $item[$field] : null;
        }

        $otherFields = $this->getOtherFields($dataType);

        foreach ($otherFields as $field) {

            if (isset($item[$field])) {
                $preparedData[$field] = $item[$field];
            }
        }

        return $preparedData;
    }

    /**
     * The method returns a list of fields to check for a numeric value for a specific data type.
     * @param string $dataType
     * @return array|string[]
     */
    protected function getFieldsForNumericValidation(string $dataType): array
    {
        return match ($dataType) {
            'vehicles' => ['cost_in_credits', 'length', 'max_atmosphering_speed', 'crew', 'passengers', 'cargo_capacity'],
            'starships' => ['cost_in_credits', 'length', 'max_atmosphering_speed', 'crew', 'passengers', 'cargo_capacity', 'hyperdrive_rating', 'MGLT'],
            'planets' => ['rotation_period', 'orbital_period', 'diameter', 'surface_water', 'population'],
            'species' => ['average_height', 'average_lifespan'],
            'films' => ['episode_id'],
            'people' => ['height', 'mass'],
            default => [],
        };
    }

    /**
     * The method returns a list of fields to import that do not require special processing.
     * @param string $dataType
     * @return array|string[]
     */
    protected function getOtherFields(string $dataType): array
    {
        return match ($dataType) {
            'vehicles' => ['name', 'model', 'manufacturer', 'consumables', 'vehicle_class'],
            'starships' => ['name', 'model', 'manufacturer', 'consumables', 'starship_class'],
            'planets' => ['name', 'climate', 'gravity', 'terrain'],
            'species' => ['name', 'classification', 'designation', 'skin_colors', 'hair_colors', 'eye_colors', 'language', 'planet_id'],
            'films' => ['title', 'opening_crawl', 'director', 'producer', 'release_date'],
            'people' => ['name', 'hair_color', 'skin_color', 'eye_color', 'birth_year', 'gender', 'planet_id', 'species_id'],
            default => [],
        };
    }

//    /**
//     * Метод для завантаження даних в таблицю Vehicles
//     * @param array $vehicles
//     * @return void
//     */
//    public function importVehicles(array $vehicles): void
//    {
//        foreach ($vehicles as $vehicle) {
//            $externalId = basename(rtrim($vehicle['url'], '/'));
//            $vehicleData = [
//                'external_id' => $externalId,
//                'name' => $vehicle['name'],
//                'model' => $vehicle['model'],
//                'manufacturer' => $vehicle['manufacturer'],
//                'cost_in_credits' => is_numeric($vehicle['cost_in_credits']) ? $vehicle['cost_in_credits'] : null,
//                'length' => is_numeric($vehicle['length']) ? $vehicle['length'] : null,
//                'max_atmosphering_speed' => is_numeric($vehicle['max_atmosphering_speed']) ? $vehicle['max_atmosphering_speed'] : null,
//                'crew' => is_numeric($vehicle['crew']) ? $vehicle['crew'] : null,
//                'passengers' => is_numeric($vehicle['passengers']) ? $vehicle['passengers'] : null,
//                'cargo_capacity' => is_numeric($vehicle['cargo_capacity']) ? $vehicle['cargo_capacity'] : null,
//                'consumables' => $vehicle['consumables'],
//                'vehicle_class' => $vehicle['vehicle_class'],
//                'created' => Carbon::parse($vehicle['created'])->format('Y-m-d H:i:s.u'),
//                'edited' => Carbon::parse($vehicle['edited'])->format('Y-m-d H:i:s.u'),
//                'url' => $vehicle['url'],
//            ];
//
//            $this->vehicleRepository->create($vehicleData);
//        }
//    }
//
//    public function importStarships(array $starships): void
//    {
//        foreach ($starships as $starship) {
//            $starshipData = [
//                'external_id' => basename($starship['url']),
//                'name' => $starship['name'],
//                'model' => $starship['model'],
//                'manufacturer' => $starship['manufacturer'],
//                'cost_in_credits' => is_numeric($starship['cost_in_credits']) ? (int)$starship['cost_in_credits'] : null,
//                'length' => is_numeric($starship['length']) ? (int)$starship['length'] : null,
//                'max_atmosphering_speed' => $starship['max_atmosphering_speed'],
//                'crew' => is_numeric($starship['crew']) ? (double)$starship['crew'] : null,
//                'passengers' => is_numeric($starship['passengers']) ? (double)$starship['passengers'] : null,
//                'cargo_capacity' => is_numeric($starship['cargo_capacity']) ? (int)$starship['cargo_capacity'] : null,
//                'consumables' => $starship['consumables'],
//                'hyperdrive_rating' => is_numeric($starship['hyperdrive_rating']) ? (float)$starship['hyperdrive_rating'] : null,
//                'MGLT' => is_numeric($starship['MGLT']) ? (int)$starship['MGLT'] : null,
//                'starship_class' => $starship['starship_class'],
//                'created' => Carbon::parse($starship['created'])->format('Y-m-d H:i:s.u'),
//                'edited' => Carbon::parse($starship['edited'])->format('Y-m-d H:i:s.u'),
//                'url' => $starship['url'],
//            ];
//
//            $this->starshipRepository->create($starshipData);
//        }
//    }
//
//    public function importPlanets(array $planets): void
//    {
//        foreach ($planets as $planet) {
//            $planetData = [
//                'external_id' => basename($planet['url']),
//                'name' => $planet['name'],
//                'rotation_period' => is_numeric($planet['rotation_period']) ? (int)$planet['rotation_period'] : null,
//                'orbital_period' => is_numeric($planet['orbital_period']) ? (int)$planet['orbital_period'] : null,
//                'diameter' => is_numeric($planet['diameter']) ? (int)$planet['diameter'] : null,
//                'climate' => $planet['climate'],
//                'gravity' => $planet['gravity'],
//                'terrain' => $planet['terrain'],
//                'surface_water' => is_numeric($planet['surface_water']) ? (int)$planet['surface_water'] : null,
//                'population' => is_numeric($planet['population']) ? (int)$planet['population'] : null,
//                'created' => Carbon::parse($planet['created'])->format('Y-m-d H:i:s.u'),
//                'edited' => Carbon::parse($planet['edited'])->format('Y-m-d H:i:s.u'),
//                'url' => $planet['url'],
//            ];
//
//            $this->planetRepository->create($planetData);
//        }
//    }
//
//    public function importSpecies(array $species): void
//    {
//        foreach ($species as $oneSpecies) {
//            $planetExternalId = intval(basename(rtrim($oneSpecies['homeworld'], '/')));
//            $planetId = $this->planetRepository->findIdByExternalId($planetExternalId);
//            $speciesData = [
//                'external_id' => basename($oneSpecies['url']),
//                'name' => $oneSpecies['name'],
//                'classification' => $oneSpecies['classification'],
//                'designation' => $oneSpecies['designation'],
//                'average_height' => is_numeric($oneSpecies['average_height']) ? (int)$oneSpecies['average_height'] : null,
//                'skin_colors' => $oneSpecies['skin_colors'],
//                'hair_colors' => $oneSpecies['hair_colors'],
//                'eye_colors' => $oneSpecies['eye_colors'],
//                'average_lifespan' => is_numeric($oneSpecies['average_lifespan']) ? (int)$oneSpecies['average_lifespan'] : null,
//                'language' => $oneSpecies['language'],
//                'created' => Carbon::parse($oneSpecies['created'])->format('Y-m-d H:i:s.u'),
//                'edited' => Carbon::parse($oneSpecies['edited'])->format('Y-m-d H:i:s.u'),
//                'url' => $oneSpecies['url'],
//                'planet_id' => $planetId,
//            ];
//
//            $this->speciesRepository->create($speciesData);
//        }
//    }
//
//    public function importFilms(array $films): void
//    {
//        foreach ($films as $film) {
//            $filmData = [
//                'external_id' => basename($film['url']),
//                'title' => $film['title'],
//                'episode_id' => is_numeric($film['episode_id']) ? (int)$film['episode_id'] : null,
//                'opening_crawl' => $film['opening_crawl'],
//                'director' => $film['director'],
//                'producer' => $film['producer'],
//                'release_date' => $film['release_date'],
//                'created' => Carbon::parse($film['created'])->format('Y-m-d H:i:s.u'),
//                'edited' => Carbon::parse($film['edited'])->format('Y-m-d H:i:s.u'),
//                'url' => $film['url'],
//            ];
//
//            $filmModel = $this->filmRepository->create($filmData);
//
//            if ($filmModel) {
//                $speciesExternalIds = collect($film['species'])->map(function ($speciesUrl) {
//                    return basename(rtrim($speciesUrl, '/'));
//                })->all();
//
//                $vehiclesExternalIds = collect($film['vehicles'])->map(function ($vehiclesUrl) {
//                    return basename(rtrim($vehiclesUrl, '/'));
//                })->all();
//
//                $starshipsExternalIds = collect($film['starships'])->map(function ($starshipsUrl) {
//                    return basename(rtrim($starshipsUrl, '/'));
//                })->all();
//
//                $planetsExternalIds = collect($film['planets'])->map(function ($planetsUrl) {
//                    return basename(rtrim($planetsUrl, '/'));
//                })->all();
//
//                $speciesIds = $this->speciesRepository->findIdsByExternalIds($speciesExternalIds);
//                $vehiclesIds = $this->vehicleRepository->findIdsByExternalIds($vehiclesExternalIds);
//                $starshipsIds = $this->starshipRepository->findIdsByExternalIds($starshipsExternalIds);
//                $planetsIds = $this->planetRepository->findIdsByExternalIds($planetsExternalIds);
//                $filmModel->species()->sync($speciesIds);
//                $filmModel->vehicles()->sync($vehiclesIds);
//                $filmModel->starships()->sync($starshipsIds);
//                $filmModel->planets()->sync($planetsIds);
//            }
//        }
//    }
//
//    public function importPeople()
//    {
//
//    }
}
