<?php

namespace App\Services\SwapiImporters;

class FilmImporter extends SwapiImporter
{
    protected array $relationsMap = ['species', 'vehicles', 'starships', 'planets'];

    protected string $dataType = 'films';

    protected function preparedData(array $item): array
    {
        $preparedData = $this->prepareBaseData($item);
        $preparedData += [
            'title' => $item['title'],
            'episode_id' => $this->isNumeric($item['episode_id']),
            'opening_crawl' => $item['opening_crawl'],
            'director' => $item['director'],
            'producer' => $item['producer'],
            'release_date' => $item['release_date'],
        ];

        return $preparedData;
    }
}
