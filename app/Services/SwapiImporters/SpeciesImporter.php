<?php

namespace App\Services\SwapiImporters;

class SpeciesImporter extends SwapiImporter
{
    protected array $relationsMap=[];
    protected string $dataType = 'species';

    protected function preparedData(array $item): array
    {
        $preparedData = $this->prepareBaseData($item);
        $preparedData += [
            'name' => $item['name'],
            'classification' => $item['classification'],
            'designation' => $item['designation'],
            'average_height' => $this->isNumeric($item['average_height']),
            'skin_colors' => $item['skin_colors'],
            'hair_colors' => $item['hair_colors'],
            'eye_colors' => $item['eye_colors'],
            'average_lifespan' => $this->isNumeric($item['average_lifespan']),
            'language' => $item['language'],
            'planet_id' => $this->getOneToManyRelationId($item['homeworld'], 'planets'),
        ];

        return $preparedData;
    }
}
