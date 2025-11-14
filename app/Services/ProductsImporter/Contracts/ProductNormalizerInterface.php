<?php
namespace App\Services\ProductsImporter\Contracts;

use App\Services\ProductsImporter\DTO\ProductImporterDTO;

interface ProductNormalizerInterface
{
    public function normalize(array $rawProduct): ?ProductImporterDTO;
}
