<?php

namespace App\Services\ProductsImporter\Factories;

use App\Models\Product;
use App\Services\ImageService;
use App\Services\ProductsImporter\DTO\ProductImporterDTO;

class ProductImporterFactory
{
    public function createFromDTO(ProductImporterDTO $dto): ?Product
    {
        if (empty($dto->ean) || empty($dto->quantity) || empty($dto->name)) {
            return null;
        }
        $product = Product::updateOrCreate(
            [
                'ean' => $dto->ean,
            ],
            [
                'name' => $dto->name,
                'brand' => $dto->brand,
                'source' => $dto->source,
                'quantity' => $dto->quantity,
                'quantity_type' => $dto->quantity_type,
                'categories' => $dto->categories,
            ]);

        $this->handleImage($dto, $product);
        return $product;
    }

    /**
     * Check if quantity string has a valid format
     */


    public function handleImage(ProductImporterDTO $dto, $product): void
    {
        if ($product->image) {
            return;
        }
        if ($dto->image_path != null) {
            (new ImageService($product))->createFromUrl($dto->image_path);
        }
        if ($dto->image != null) {
            (new ImageService($product))->create($dto->image);
        }
    }
}
