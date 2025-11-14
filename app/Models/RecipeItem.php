<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class RecipeItem extends Model
{
    use HasUuids;

    protected $fillable = [
        'recipe_id',
        'product_id',
        'quantity',
        'optional',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'optional' => 'boolean',
    ];
}
