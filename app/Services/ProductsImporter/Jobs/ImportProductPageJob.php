<?php

namespace App\Services\ProductsImporter\Jobs;

use App\Services\ProductsImporter\ProductImporter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportProductPageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly int $page,
        public readonly int $perPage
    )
    {
    }

    public function handle(ProductImporter $importer): void
    {
        $importer->import(
            [
                'page' => $this->page,
                'page_size' => $this->perPage,
            ]
        );
    }
}
