<?php

namespace App\Services\SwapiImporters;

class PlanetImporter extends SwapiImporter
{
    protected array $relationsMap=[];
    protected string $dataType = 'planets';

    protected function preparedData(array $item): array
    {
        $preparedData = $this->prepareBaseData($item);
        $preparedData += [
            'name' => $item['name'],
            'rotation_period' => $this->isNumeric($item['rotation_period']),
            'orbital_period' => $this->isNumeric($item['orbital_period']),
            'diameter' => $this->isNumeric($item['diameter']),
            'climate' => $item['climate'],
            'gravity' => $item['gravity'],
            'terrain' => $item['terrain'],
            'surface_water' => $this->isNumeric($item['surface_water']),
            'population' => $this->isNumeric($item['population']) ,
        ];

        return $preparedData;
    }
}
