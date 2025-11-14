<?php

namespace App\Observers;

use App\Models\Recipe;
use Ramsey\Uuid\Uuid;

class RecipeObserver
{
    /**
     * Stuff needs to be done while model is creating
     *
     * @param Recipe $recipe
     */
    public function creating(Recipe $recipe)
    {
        if (! $recipe->id) {
            $recipe->id = Uuid::uuid4()->toString();
        }
        //TODO set version, make is_latest etc.
    }
}
