<?php

namespace App\Services\ProductsImporter\Normalizers;

use App\Services\ProductsImporter\Contracts\ProductNormalizerInterface;
use App\Services\ProductsImporter\DTO\ProductImporterDTO;

class OpenFoodFactsNormalizer implements ProductNormalizerInterface
{
    public function normalize(array $rawProduct): ?ProductImporterDTO
    {
        if (empty($rawProduct['product_name']) || empty($rawProduct['code']) || empty($rawProduct['quantity']) || !$this->validateQuantity($rawProduct['quantity'])) {
            return null;
        }
        return new ProductImporterDTO(
            ean: $rawProduct['code'],
            name: $rawProduct['product_name'],
            source: 'open_food_facts',
            image_path: $rawProduct['image_url'] ?? null,
            image: null,
            brand: $rawProduct['brands'] ?? null,
            quantity: $this->extractQuantity($rawProduct['quantity'] ?? ''),
            quantity_type: $this->extractQuantityType($rawProduct['quantity'] ?? ''),
            categories: $raw['categories_tags'] ?? null,
        );
    }

    /**
     * Sprawdza, czy quantity jest poprawne
     */
    public function validateQuantity(?string $quantity): bool
    {
        if (empty($this->extractQuantity($quantity)) || empty($this->extractQuantityType($quantity))) {
            return false;
        }

        return true;
    }

    public function extractQuantity(?string $quantity): ?float
    {
        if (empty($quantity)) {
            return null;
        }

        $quantity = strtolower($quantity);

        // Wydobycie wszystkich liczb: np. [330, 345]
        preg_match_all('/(\d+[\.,]?\d*)/', $quantity, $matches);

        if (empty($matches[1])) {
            return null;
        }

        // W przypadku wielu wartości – zwykle pierwszy element to główny
        $value = (float)str_replace(',', '.', $matches[1][0]);

        // Konwersja w zależności od typu
        $unit = $this->extractQuantityType($quantity);

        if (!$unit) {
            return $value;
        }

        return match ($unit) {
            'kg' => $value * 1000,     // na gramy
            'l' => $value * 1000,     // na ml
            default => $value,
        };
    }


    /**
     * Zwraca znormalizowaną jednostkę: g, kg, ml, l, szt
     * Wyciąga jednostkę z formatów złożonych i mieszanego zapisu.
     */
    public function extractQuantityType(?string $quantity): ?string
    {
        if (empty($quantity)) {
            return null;
        }

        $quantity = strtolower($quantity);

        // znajdź wszystkie jednostki
        preg_match_all('/[a-zA-Z]+/', $quantity, $matches);

        if (empty($matches[0])) {
            return null;
        }

        $units = array_map('strtolower', $matches[0]);

        // priorytet — jednostki stałe (g/ml)
        foreach ($units as $unit) {
            $normalized = $this->normalizeUnit($unit);
            if ($normalized) {
                return $normalized;
            }
        }

        return null;
    }

    /**
     * Normalizuje jednostkę do formatu g / kg / ml / l / szt
     */
    protected function normalizeUnit(string $unit): ?string
    {
        return match ($unit) {
            'g', 'gr', 'gram' => 'g',
            'kg', 'kilo', 'kilogram' => 'kg',

            'ml' => 'ml',
            'l', 'liter', 'litre', 'ltr' => 'l',
            'cl' => 'cl',
            'dl' => 'dl',

            'pcs', 'piece', 'pieces', 'szt', 'szt.' => 'szt',

            default => null,
        };
    }

}
