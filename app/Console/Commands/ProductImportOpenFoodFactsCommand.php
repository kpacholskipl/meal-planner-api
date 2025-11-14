<?php

namespace App\Console\Commands;

use App\Services\ProductsImporter\Jobs\ImportProductPageJob;
use App\Services\ProductsImporter\Normalizers\OpenFoodFactsNormalizer;
use App\Services\ProductsImporter\ProductImporter;
use App\Services\ProductsImporter\Providers\OpenFoodFactsProvider;
use Exception;
use Illuminate\Console\Command;

class ProductImportOpenFoodFactsCommand extends Command
{
    protected $signature = 'product:import:openfoodfacts
          {--per-page=10 : Ilość produktów na stronę}
          {--skip=0 : Ilość produktów do pominięcia}';

    protected $description = 'Import products from a provider';

    public function handle(): void
    {
        $this->info('Starting import of products from OpenFoodFacts...');
        $pageSize = (int)$this->option('per-page');
        $importer = new ProductImporter(
            new OpenFoodFactsProvider(new OpenFoodFactsNormalizer())
        );

        try {
            $totalCount = $this->getTotalProductsCount($importer, $pageSize);

            if ($totalCount === 0) {
                $this->warn('Non products to import');
                return;
            }

            $totalPages = (int)ceil($totalCount / $pageSize);

            $this->importAllPages($importer, $pageSize, $totalPages);

            $this->info(sprintf('The import has been finished. Imported products form %d pages.', $totalPages));
        } catch (Exception $e) {
            $this->error(sprintf('Error during of import: %s', $e->getMessage()));
            $this->error($e->getTraceAsString());
        }
    }

    private function getTotalProductsCount(ProductImporter $importer, int $pageSize): int
    {
        $result = $importer->import(['page_size' => 1, 'page' => 1]);
        $totalCount = $result['total_count'] ?? 0;

        $this->info(sprintf('Znaleziono %d produktów do zaimportowania.', $totalCount));

        return $totalCount;
    }

    private function importAllPages(ProductImporter $importer, int $pageSize, int $totalPages): void
    {
        $progressBar = $this->output->createProgressBar($totalPages);
        $progressBar->start();
        for ($page = 1; $page <= $totalPages; $page++) {
            ImportProductPageJob::dispatch($page, $pageSize)
                ->onQueue("imports");

            $progressBar->advance();
            $this->newLine();
            $this->info(sprintf('Dispatching job for page %d of %d', $page, $totalPages));
        }

        $progressBar->finish();
        $this->newLine(2);
        $this->info(sprintf('Dispatched %d import jobs to the queue', $totalPages));
    }
}
