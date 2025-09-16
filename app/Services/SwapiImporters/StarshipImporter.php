<?php

namespace App\Services\SwapiImporters;


class StarshipImporter extends SwapiImporter
{
    protected array $relationsMap=[];
    protected string $dataType = 'starships';

    protected function preparedData(array $item): array
    {
        $preparedData = $this->prepareBaseData($item);
        $preparedData += [
                'name' => $item['name'],
                'model' => $item['model'],
                'manufacturer' => $item['manufacturer'],
                'cost_in_credits' => $this->getNumericOrNull($item['cost_in_credits']),
                'length' => $this->getNumericOrNull($item['length']),
                'max_atmosphering_speed' => $this->getNumericOrNull($item['max_atmosphering_speed']),
                'crew' => $this->getNumericOrNull($item['crew']),
                'passengers' => $this->getNumericOrNull($item['passengers']),
                'cargo_capacity' => $this->getNumericOrNull($item['cargo_capacity']),
                'consumables' => $item['consumables'],
                'hyperdrive_rating' => $this->getNumericOrNull($item['hyperdrive_rating']),
                'MGLT' => $this->getNumericOrNull($item['MGLT']),
                'starship_class' => $item['starship_class'],
        ];

        return $preparedData;
    }
}
