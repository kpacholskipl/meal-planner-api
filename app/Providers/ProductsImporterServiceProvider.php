<?php

namespace App\Providers;

use App\Services\ProductsImporter\Contracts\ProductNormalizerInterface;
use App\Services\ProductsImporter\Contracts\ProductProviderInterface;
use App\Services\ProductsImporter\Normalizers\OpenFoodFactsNormalizer;
use App\Services\ProductsImporter\ProductImporter;
use App\Services\ProductsImporter\Providers\OpenFoodFactsProvider;
use Illuminate\Support\ServiceProvider;

class ProductsImporterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProductProviderInterface::class, OpenFoodFactsProvider::class);
        $this->app->bind(ProductNormalizerInterface::class, OpenFoodFactsNormalizer::class);

        $this->app->when(ProductImporter::class)
            ->needs(ProductProviderInterface::class)
            ->give(OpenFoodFactsProvider::class);

        $this->app->when(ProductImporter::class)
            ->needs(ProductNormalizerInterface::class)
            ->give(OpenFoodFactsNormalizer::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
