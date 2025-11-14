<?php

namespace Database\Factories;

use App\Models\Nutrient;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class NutrientFactory extends Factory
{
    protected $model = Nutrient::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'energy_kcal_100g' => $this->faker->randomFloat(2, 0, 900),
            'fat_100g' => $this->faker->randomFloat(2, 0, 100),
            'saturated_fat_100g' => $this->faker->randomFloat(2, 0, 50),
            'carbohydrates_100g' => $this->faker->randomFloat(2, 0, 100),
            'sugars_100g' => $this->faker->randomFloat(2, 0, 100),
            'fiber_100g' => $this->faker->randomFloat(2, 0, 30),
            'proteins_100g' => $this->faker->randomFloat(2, 0, 100),
            'salt_100g' => $this->faker->randomFloat(2, 0, 10),
            'sodium_100g' => $this->faker->randomFloat(2, 0, 5),
        ];
    }
}
