<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nutrients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_id')->constrained()->onDelete('cascade');
            $table->float('energy_kcal_100g')->nullable();
            $table->float('fat_100g')->nullable();
            $table->float('saturated_fat_100g')->nullable();
            $table->float('carbohydrates_100g')->nullable();
            $table->float('sugars_100g')->nullable();
            $table->float('fiber_100g')->nullable();
            $table->float('proteins_100g')->nullable();
            $table->float('salt_100g')->nullable();
            $table->float('sodium_100g')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nutrients');
    }
};
