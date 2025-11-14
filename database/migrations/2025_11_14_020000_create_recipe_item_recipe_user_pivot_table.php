<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recipe_item_recipe_user', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('recipe_user_id')->constrained('recipe_user')->onDelete('cascade');
            $table->foreignUuid('recipe_item_id')->constrained('recipe_items')->onDelete('cascade');
            $table->unsignedInteger('quantity');
            $table->timestamps();

            $table->unique(['recipe_user_id', 'recipe_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_item_recipe_user');
    }
};
