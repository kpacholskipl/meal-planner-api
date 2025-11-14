<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Http\Resources\RecipeResource;
use App\Models\Product;
use App\Models\Recipe;
use App\Http\Requests\StoreRecipeRequest;
use App\Services\ImageService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return RecipeResource::collection(Recipe::paginate());
    }

    public function store(StoreRecipeRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $recipe = $request->user()->recipes()->create(
                    $request->validated()
                );


                if ($request->has('items')) {
                    $items = $request->items;
                    foreach ($items as $item) {
                        $recipe->items()->create([
                            'product_id' => $item['product_id'],
                            'user_id' => $request->user()->id,
                            'quantity' => $item['quantity'],
                            'optional' => boolval($item['optional']),
                        ]);
                    }
                }

                DB::commit();

                if ($request->has('image')) {
                    $image = new ImageService($recipe);
                    $image->create($request->image);
                }

                return response()->json([
                    'message' => 'Recipe created successfully',
                    'data' => $recipe
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create recipe',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe): RecipeResource
    {
        return new RecipeResource($recipe);
    }
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        return response()->json([
            'message' => 'Recipe deleted successfully'
        ], 200);
    }
}
