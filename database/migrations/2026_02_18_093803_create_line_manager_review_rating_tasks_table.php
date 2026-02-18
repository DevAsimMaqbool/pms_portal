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
        Schema::create('line_manager_review_rating_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('line_manager_review_rating_id');
            $table->string('task');               // Task name
            $table->decimal('linemanager_rating', 3, 1); // Rating like 4.5
            $table->enum('status', ['1', '2', '3', '4', '5', '6'])->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_manager_review_rating_tasks');
    }
};
