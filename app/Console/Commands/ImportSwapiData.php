<?php

namespace App\Console\Commands;

use App\Enums\SwapiDataType;
use App\Jobs\ImportSwapiPage;
use App\Services\ImportSwapiService\SwapiApiService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ImportSwapiData extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'app:import-swapi-data {--from-type= : Start importing from a specific data type }';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Imports all data from https://swapi-api.hbtn.io/api/ into the database';

    protected array $importOrder = ['vehicles', 'starships', 'planets', 'species', 'films', 'people'];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle(SwapiApiService $apiService): int
    {
        $this->info("Starting SWAPI data import process...");
        $startType = $this->option('from-type');

        try {
            $endpoints = $apiService->getEndpoints();
        } catch (\Exception $e) {
            $this->error("Failed to get endpoints from API: " . $e->getMessage());

            return CommandAlias::FAILURE;
        }

        $startIndex = $startType ? array_search($startType, $this->importOrder) : 0;

        if ($startIndex === false) {
            $this->error("Invalid data type provided: '{$startType}'.");

            return CommandAlias::FAILURE;
        }

        $jobsToRun = array_slice($this->importOrder, $startIndex);
        $jobs = [];

        foreach ($jobsToRun as $dataType) {

            if (isset($endpoints[$dataType])) {
                $jobs[] = new ImportSwapiPage($endpoints[$dataType], SwapiDataType::from($dataType));
            }
        }

        if (count($jobs) > 0) {
            Bus::chain($jobs)->dispatch();
            $this->info("Import chain has been successfully dispatched.");

            return CommandAlias::SUCCESS;
        } else {
            $this->error("No valid endpoints found for import.");

            return CommandAlias::FAILURE;
        }
    }
}
