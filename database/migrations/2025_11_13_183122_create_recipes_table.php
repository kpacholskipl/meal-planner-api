<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid('root_id')->nullable();
            $table->uuid('user_id');
            $table->unsignedInteger('version')->default(1);
            $table->unsignedInteger('status')->default(0);
            $table->boolean('is_latest')->default(true);
            $table->string('name');
            $table->text('description');
            $table->text('preparation')->nullable();
            $table->integer('kcal')->nullable();
            $table->integer('preparation_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
