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
        Schema::create('goal_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->foreignId('goal_id')->constrained('goals')->cascadeOnDelete();

            $table->foreignId('objective_id')->constrained('objectives')->cascadeOnDelete();

            $table->foreignId('dimension_id')->constrained('dimensions')->cascadeOnDelete();
            $table->foreignId('kpa_id')->constrained('key_performance_areas')->cascadeOnDelete();
            $table->decimal('dimension_target', 10, 2)->nullable();
            $table->decimal('dimension_weight', 10, 2)->nullable();

            // Multiple KPI IDs
            $table->json('kpi_ids')->nullable();
            $table->enum('validate', ['1', '2', '3', '4', '5', '6'])->default('1');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->unique([
                'role_id',
                'goal_id',
                'objective_id',
                'dimension_id',
                'kpa_id'
            ], 'goal_assignment_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goal_assignments');
    }
};
