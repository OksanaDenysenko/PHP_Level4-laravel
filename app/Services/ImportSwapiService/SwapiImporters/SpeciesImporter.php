<?php

namespace App\Services\ImportSwapiService\SwapiImporters;

use App\Enums\SwapiDataType;

class SpeciesImporter extends SwapiImporter
{
    protected array $relationsMap=[];
    protected SwapiDataType $dataType = SwapiDataType::Species;

    protected function preparedData(array $item): array
    {
        $preparedData = $this->prepareBaseData($item);
        $preparedData += [
            'name' => $item['name'],
            'classification' => $item['classification'],
            'designation' => $item['designation'],
            'average_height' => $this->getNumericOrNull($item['average_height']),
            'skin_colors' => $item['skin_colors'],
            'hair_colors' => $item['hair_colors'],
            'eye_colors' => $item['eye_colors'],
            'average_lifespan' => $this->getNumericOrNull($item['average_lifespan']),
            'language' => $item['language'],
            'planet_id' => $this->getOneToManyRelationId($item['homeworld'], SwapiDataType::Planets),
        ];

        return $preparedData;
    }
}
