<?php

namespace App\Services\SwapiImporters;

class VehicleImporter extends SwapiImporter
{
    protected array $relationsMap=[];
    protected string $dataType = 'vehicles';

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
            'cargo_capacity' =>$this->isNumeric($item['cargo_capacity']),
            'consumables' => $item['consumables'],
            'vehicle_class' => $item['vehicle_class'],
        ];

        return $preparedData;
    }
}
