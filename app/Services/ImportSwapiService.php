<?php

namespace App\Services;

use App\Enums\SwapiDataType;

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
        $enumDataType = SwapiDataType::from($dataType);

        if (!isset($this->importers[$enumDataType->value])) {
            $this->importers[$enumDataType->value] = $enumDataType->getImporter();
        }

        $importer = $this->importers[$enumDataType->value];
        $importer->import($data);
    }

//    /**
//     * The method creates an importer object based on the data type
//     * @param string $dataType
//     * @return SwapiImporter|null
//     */
//    protected function createImporter(string $dataType): SwapiImporter|null
//    {
//        return match ($dataType) {
//            'films' => new FilmImporter(),
//            'people' => new PersonImporter(),
//            'planets' => new PlanetImporter(),
//            'species' => new SpeciesImporter(),
//            'starships' => new StarshipImporter(),
//            'vehicles' => new VehicleImporter(),
//            default => null,
//        };
//    }
}
