<?php

namespace App\Enums;

use App\Repository\{Repository,FilmRepository,PersonRepository,PlanetRepository,SpeciesRepository,StarshipRepository,VehicleRepository};
use App\Services\SwapiImporters\{SwapiImporter,VehicleImporter,StarshipImporter,SpeciesImporter,PlanetImporter,PersonImporter,FilmImporter};

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

    /**
     * This method returns the corresponding repository object
     * @return Repository
     */
    public function getRepository(): Repository
    {
        return match ($this) {
            self::Films => new FilmRepository(),
            self::People => new PersonRepository(),
            self::Planets => new PlanetRepository(),
            self::Species => new SpeciesRepository(),
            self::Starships => new StarshipRepository(),
            self::Vehicles => new VehicleRepository(),
        };
    }
}
