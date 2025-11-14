<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipeItemRecipeUser extends Model
{
    use HasUuids;
    protected $table = 'recipe_item_recipe_user';
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $fillable = [
        'recipe_user_id',
        'recipe_item_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];
}
