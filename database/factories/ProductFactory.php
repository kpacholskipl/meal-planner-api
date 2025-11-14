<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {

        return [
            'ean' => $this->faker->unique()->ean13,
            'name' => $this->faker->word,
            'brand' => $this->faker->company,
            'quantity' => $this->faker->numberBetween(1, 500),
            'quantity_type' => $this->faker->randomElement(['g', 'ml']),
            //
            'categories' => json_encode($this->faker->randomElements(
                [
                    'Dairy & Eggs',
                    'Beverages',
                    'Snacks',
                    'Bakery',
                    'Meat & Poultry',
                    'Fruits & Vegetables',
                    'Grains & Pasta',
                    'Canned & Jarred',
                    'Frozen Foods',
                    'Baking & Cooking',
                    'Spices & Seasonings',
                    'Oils & Vinegars',
                    'Cereals & Breakfast',
                    'Sauces & Condiments',
                    'Soups & Broths'
                ],
                $this->faker->numberBetween(1, 3)
            )),
            'source' => 'manual',
            'user_id' => User::factory(),
        ];
    }
}
