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
        Schema::create('indicators_percentages', function (Blueprint $table) {
            $table->id();

            // Employee (user)
            $table->unsignedBigInteger('employee_id')->index()->nullable();
            // Key Performance Area
            $table->unsignedBigInteger('key_performance_area_id')->index()->nullable();
            // Indicator  Category
            $table->unsignedBigInteger('indicator_category_id')->index()->nullable();
            // Indicator
            $table->unsignedBigInteger('indicator_id')->index()->nullable();

            // Calculated score
            $table->decimal('score', 5, 2)->nullable();

            $table->string('rating', 15)->nullable();
            $table->string('color', 15)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicators_percentages');
    }
};
