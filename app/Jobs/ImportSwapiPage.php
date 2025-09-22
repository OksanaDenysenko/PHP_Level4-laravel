<?php

namespace App\Jobs;

use App\Enums\SwapiDataType;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\SwapiApiService;
use App\Services\ImportSwapiService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ImportSwapiPage implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $url,
                                protected SwapiDataType $dataType)
    {
    }

    /**
     * Execute the job.
     * @throws \Exception
     */
    public function handle(SwapiApiService $apiService, ImportSwapiService $importSwapiService): void
    {
        $data = $apiService->getPage($this->url);

        if (!isset($data['results'])) {
            logger()->error("There is no data to import from URL: {$this->url}");

            return;
        }

        $importSwapiService->importData($this->dataType, $data['results']);

        if ($data['next']) {
            ImportSwapiPage::dispatch($data['next'], $this->dataType);
        }
    }
}
