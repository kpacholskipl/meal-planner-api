<?php

namespace App\Services\ProductsImporter\DTO;

readonly class ProductImporterDTO
{
    public function __construct(
        public string  $ean,
        public string  $name,
        public string  $source = 'manual',
        public ?string $image_path = null,
        public ?string $image = null,
        public ?string $brand = null,
        public ?string $quantity = null,
        public ?string $quantity_type = null,
        public ?array  $categories = null,
    )
    {
    }
}
