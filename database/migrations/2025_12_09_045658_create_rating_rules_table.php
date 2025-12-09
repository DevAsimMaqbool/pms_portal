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
        Schema::create('rating_rules', function (Blueprint $table) {
            $table->id();
            $table->integer('min_percentage');     // e.g., 90
            $table->integer('max_percentage');     // e.g., 100
            $table->string('rating');              // OS, EE, ME...
            $table->string('description')->nullable();
            $table->string('color');
            $table->enum('status', ['1', '2', '3', '4', '5', '6'])->default('1');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating_rules');
    }
};
