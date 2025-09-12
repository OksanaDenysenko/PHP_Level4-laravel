<?php

namespace App\Console\Commands;

use App\Jobs\ImportSwapiPage;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ImportSwapiData extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'app:import-swapi-data';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Imports all data from https://swapi-api.hbtn.io/api/ into the database';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info("Starting SWAPI data import process...");
        $endpoints = config('swapi.endpoints');
        $allJobsDispatched = true;

        foreach ($endpoints as $item) {
            try {
                $this->info("Dispatching job for {$item['name']} ...");
                ImportSwapiPage::dispatch($item['url'], $item['name'], $item['queue'])->onQueue($item['queue']);

            } catch (\Exception $e) {
                $this->error("Failed to dispatch job for {$item['name']}: " . $e->getMessage());
                $allJobsDispatched = false;
            }
        }

        if ($allJobsDispatched) {
            $this->info("All initial import jobs have been dispatched successfully.");
           // $this->info("Run 'php artisan queue:work --queue=1,2,3,4 --tries=3' to process them.");

            return CommandAlias::SUCCESS;
        } else {
            $this->error("Some jobs failed to dispatch. Check the logs for details.");

            return CommandAlias::FAILURE;
        }
    }
}
