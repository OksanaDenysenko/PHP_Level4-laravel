<?php

namespace App\Services\ImportSwapiService\SwapiImporters;

use App\Enums\SwapiDataType;

class FilmImporter extends SwapiImporter
{
    protected array $relationsMap = ['species', 'vehicles', 'starships', 'planets'];

    protected SwapiDataType $dataType = SwapiDataType::Films;

    protected function preparedData(array $item): array
    {
        $preparedData = $this->prepareBaseData($item);
        $preparedData += [
            'title' => $item['title'],
            'episode_id' => $this->getNumericOrNull($item['episode_id']),
            'opening_crawl' => $item['opening_crawl'],
            'director' => $item['director'],
            'producer' => $item['producer'],
            'release_date' => $item['release_date'],
        ];

        return $preparedData;
    }
}
