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
        Schema::create('goal_assignment_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goal_assignment_detail_id') ->constrained()->cascadeOnDelete();
            $table->unsignedInteger('indicator_id');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goal_assignment_indicators');
    }
};
