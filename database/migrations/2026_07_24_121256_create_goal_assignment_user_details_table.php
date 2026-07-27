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
        Schema::create('goal_assignment_user_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('goal_assignment_id')
                ->constrained('goal_assignments')
                ->cascadeOnDelete();

            $table->foreignId('goal_assignment_detail_id')
                ->constrained('goal_assignment_details')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('target_achieved', 10, 2)->default(0);

            $table->text('remarks')->nullable();

            $table->enum('status', [
                'Pending',
                'In Progress',
                'Completed'
            ])->default('Pending');

            $table->timestamps();

            $table->unique([
                'goal_assignment_detail_id',
                'user_id'
            ], 'goal_assignment_user_detail_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goal_assignment_user_details');
    }
};
