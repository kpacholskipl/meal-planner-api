<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nutrient extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nutrients';

    protected $fillable = [
        'product_id',
        'energy_kcal_100g',
        'fat_100g',
        'saturated_fat_100g',
        'carbohydrates_100g',
        'sugars_100g',
        'fiber_100g',
        'proteins_100g',
        'salt_100g',
        'sodium_100g',
    ];

    protected $casts = [
        'energy_kcal_100g' => 'float',
        'fat_100g' => 'float',
        'saturated_fat_100g' => 'float',
        'carbohydrates_100g' => 'float',
        'sugars_100g' => 'float',
        'fiber_100g' => 'float',
        'proteins_100g' => 'float',
        'salt_100g' => 'float',
        'sodium_100g' => 'float',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
