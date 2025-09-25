<?php

namespace App\Services\SwapiImporters;

use App\Enums\SwapiDataType;

class PersonImporter extends SwapiImporter
{
    protected array $relationsMap = ['vehicles', 'starships', 'films'];
    protected SwapiDataType $dataType = SwapiDataType::People;

    protected function preparedData(array $item): array
    {
        $preparedData = $this->prepareBaseData($item);
        $preparedData += [
            'name' => $item['name'],
            'height' => $this->getNumericOrNull($item['height']),
            'mass' => $this->getNumericOrNull($item['mass']),
            'hair_color' => $item['hair_color'],
            'skin_color' => $item['skin_color'],
            'eye_color' => $item['eye_color'],
            'birth_year' => $item['birth_year'],
            'gender' => $item['gender'],
            'planet_id' => $this->getOneToManyRelationId($item['homeworld'],SwapiDataType::Planets),
            'species_id' => $this->getOneToManyRelationId(
                !empty($item['species']) ? $item['species'][0] : null,SwapiDataType::Species),
        ];

        return $preparedData;
    }
}
