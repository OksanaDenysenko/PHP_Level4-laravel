<?php

namespace App\Services\ImportSwapiService;

use App\Enums\SwapiDataType;

class ImportSwapiService
{
    protected array $importers = [];

    /**
     * The method performs the general process of importing data from SWAPI into the database
     * @param SwapiDataType $dataType
     * @param array $data
     * @return void
     */
    public function importData(SwapiDataType $dataType, array $data): void
    {
        if (!isset($this->importers[$dataType->value])) {
            $this->importers[$dataType->value] = $dataType->getImporter();
        }

        $importer = $this->importers[$dataType->value];
        $importer->import($data);
    }
}
