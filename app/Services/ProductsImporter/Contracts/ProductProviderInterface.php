<?php

namespace App\Services\ProductsImporter\Contracts;


use App\Services\ProductsImporter\DTO\ProductImporterDTO;

interface ProductProviderInterface
{
    /**
     * @param array|null $params
     * @return array{data: ProductImporterDTO[], total_count?: int}
     */
    public function fetchProducts(?array $params = null): array;
}
