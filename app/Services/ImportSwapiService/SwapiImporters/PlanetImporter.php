<?php

namespace App\Services\ImportSwapiService\SwapiImporters;

use App\Enums\SwapiDataType;

class PlanetImporter extends SwapiImporter
{
    protected array $relationsMap=[];
    protected SwapiDataType $dataType = SwapiDataType::Planets;

    protected function preparedData(array $item): array
    {
        $preparedData = $this->prepareBaseData($item);
        $preparedData += [
            'name' => $item['name'],
            'rotation_period' => $this->getNumericOrNull($item['rotation_period']),
            'orbital_period' => $this->getNumericOrNull($item['orbital_period']),
            'diameter' => $this->getNumericOrNull($item['diameter']),
            'climate' => $item['climate'],
            'gravity' => $item['gravity'],
            'terrain' => $item['terrain'],
            'surface_water' => $this->getNumericOrNull($item['surface_water']),
            'population' => $this->getNumericOrNull($item['population']) ,
        ];

        return $preparedData;
    }
}
