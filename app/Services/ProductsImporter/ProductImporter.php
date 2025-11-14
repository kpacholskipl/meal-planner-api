<?php

namespace App\Services\ProductsImporter;

use App\Services\ProductsImporter\Contracts\ProductProviderInterface;
use App\Services\ProductsImporter\Factories\ProductImporterFactory;

class ProductImporter
{
    public function __construct(protected ProductProviderInterface $provider)
    {
    }

    /**
     * @param array $params
     * @return array
     */
    public function import(array $params = []): array
    {
        $factory = new ProductImporterFactory();
        $result = $this->provider->fetchProducts($params);

        $products = $result['data'] ?? [];
        $total = $result['total_count'] ?? count($products);

        $result = [];
        foreach ($products as $dto) {
            $result[] = $factory->createFromDTO($dto);
        }

        return ['products' => $result, 'total_count' => $total];
    }
}
