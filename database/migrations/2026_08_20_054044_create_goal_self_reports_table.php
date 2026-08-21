<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('goal_self_reports', function (Blueprint $table) {

            $table->id();

            /*
             * Goal
             */
            $table->foreignId('new_goal_id')
                ->constrained('new_goals')
                ->cascadeOnDelete();

            /*
             * Employee
             */
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
             * Employee's progress
             */
            $table->text('progress_against_goal');

            /*
             * not_started
             * in_progress
             * partially_complete
             * completed
             */
            $table->enum('achievement_status', [
                'not_started',
                'in_progress',
                'partially_complete',
                'completed',
            ]);

            /*
             * Employee self rating
             *
             * Not Started = 0
             * In Progress = 1
             * Partially Complete = 3
             * Completed = 5
             */
            $table->unsignedTinyInteger('rating')
                ->default(0);

            /*
             * Line Manager rating
             */
            $table->unsignedTinyInteger('manager_rating')
                ->nullable();

            /*
             * HR final rating
             */
            $table->unsignedTinyInteger('hr_rating')
                ->nullable();

            /*
             * Workflow status
             */
            $table->enum('status', [
                'submitted',
                'manager_approved',
                'manager_rejected',
                'hr_approved',
                'hr_rejected',
            ])->default('submitted');

            /*
             * Dates
             */
            $table->timestamp('submitted_at')
                ->nullable();

            $table->timestamp('manager_reviewed_at')
                ->nullable();

            $table->timestamp('hr_reviewed_at')
                ->nullable();

            $table->timestamps();

            /*
             * Useful indexes
             */
            $table->index([
                'new_goal_id',
                'status',
            ]);

            $table->index([
                'user_id',
                'status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goal_self_reports');
    }
};