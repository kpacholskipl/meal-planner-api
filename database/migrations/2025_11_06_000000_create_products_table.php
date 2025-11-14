<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('ean')->unique();
            $table->integer('quantity');
            $table->string('quantity_type');
            $table->enum('source', ['open_food_facts', 'manual', 'user', 'external']);
            $table->string('brand')->nullable();
            $table->string('categories')->nullable();
            $table->foreignUuid('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
