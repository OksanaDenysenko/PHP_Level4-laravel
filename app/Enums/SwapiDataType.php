<?php

namespace App\Enums;

use App\Services\SwapiImporters\FilmImporter;
use App\Services\SwapiImporters\PersonImporter;
use App\Services\SwapiImporters\PlanetImporter;
use App\Services\SwapiImporters\SpeciesImporter;
use App\Services\SwapiImporters\StarshipImporter;
use App\Services\SwapiImporters\SwapiImporter;
use App\Services\SwapiImporters\VehicleImporter;

enum SwapiDataType: string
{
    case Films = 'films';
    case People = 'people';
    case Planets = 'planets';
    case Species = 'species';
    case Starships = 'starships';
    case Vehicles = 'vehicles';

    /**
     * This method returns the corresponding importer object (SwapiImporter)
     * based on the value of the Enum itself
     * @return SwapiImporter
     */
    public function getImporter(): SwapiImporter
    {
        return match ($this) {
            self::Films => new FilmImporter(),
            self::People => new PersonImporter(),
            self::Planets => new PlanetImporter(),
            self::Species => new SpeciesImporter(),
            self::Starships => new StarshipImporter(),
            self::Vehicles => new VehicleImporter(),
        };
    }
}
