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
                'cost_in_credits' => $this->isNumeric($item['cost_in_credits']),
                'length' => $this->isNumeric($item['length']),
                'max_atmosphering_speed' => $this->isNumeric($item['max_atmosphering_speed']),
                'crew' => $this->isNumeric($item['crew']),
                'passengers' => $this->isNumeric($item['passengers']),
                'cargo_capacity' => $this->isNumeric($item['cargo_capacity']),
                'consumables' => $item['consumables'],
                'hyperdrive_rating' => $this->isNumeric($item['hyperdrive_rating']),
                'MGLT' => $this->isNumeric($item['MGLT']),
                'starship_class' => $item['starship_class'],
        ];

        return $preparedData;
    }
}
