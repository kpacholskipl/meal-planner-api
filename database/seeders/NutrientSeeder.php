<?php

namespace Database\Seeders;

use App\Models\Nutrient;
use App\Models\Product;
use Illuminate\Database\Seeder;

class NutrientSeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();

        foreach ($products as $product) {
            Nutrient::factory()->create([
                'product_id' => $product->id,
            ]);
        }
    }
}
