<?php

namespace App\Services\Swapi\SwapiImporters;

use App\Enums\SwapiDataType;

class VehicleImporter extends SwapiImporter
{
    protected array $relationsMap=[];
    protected SwapiDataType $dataType = SwapiDataType::Vehicles;

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
            'cargo_capacity' =>$this->getNumericOrNull($item['cargo_capacity']),
            'consumables' => $item['consumables'],
            'vehicle_class' => $item['vehicle_class'],
        ];

        return $preparedData;
    }
}
