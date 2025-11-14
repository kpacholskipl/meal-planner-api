<?php

namespace App\Services\ProductsImporter\Providers;

use App\Services\ProductsImporter\Contracts\ProductNormalizerInterface;
use App\Services\ProductsImporter\Contracts\ProductProviderInterface;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class OpenFoodFactsProvider implements ProductProviderInterface
{
    public function __construct(protected ProductNormalizerInterface $normalizer)
    {

    }

    public function fetchProducts(array $params = null): array
    {
        $response = Http::get('https://api.openfoodfacts.org/api/v2/search', [
            'countries_tags' => 'pl',
            'lang' => 'pl',
            'lc' => 'pl',
            'page_size' => $params['page_size'] ?? 10,
            'page' => $params['page'] ?? 1,
            'skip' => $params['skip'] ?? 0,
            'fields' => $params['fields'] ?? 'code,product_name,brands,quantity,image_url,categories,nutriscore_grade,nutriments,ingredients_text,allergens_tags,traces_tags',
        ]);
        if ($response->failed()) {
            throw new RuntimeException(
                sprintf('OpenFoodFacts API request failed: [%d] %s', $response->status(), $response->body())
            );
        }

        $json = $response->json();
        $products = $json['products'] ?? [];
//        dd($products);
        return [
            'data' => array_values(array_filter(
                array_map(fn($raw) => $this->normalizer->normalize($raw), $products)
            )),
            'total_count' => $json['count'] ?? null,
        ];
    }
}
