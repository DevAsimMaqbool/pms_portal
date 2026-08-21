<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('goal_report_reviews', function (Blueprint $table) {

            $table->id();

            /*
             * Self report
             */
            $table->foreignId('goal_self_report_id')
                ->constrained('goal_self_reports')
                ->cascadeOnDelete();

            /*
             * Reviewer
             */
            $table->foreignId('reviewer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
             * manager / hr
             */
            $table->enum('reviewer_type', [
                'manager',
                'hr',
            ]);

            /*
             * approved / rejected
             */
            $table->enum('decision', [
                'approved',
                'rejected',
            ]);

            /*
             * Reviewer rating
             *
             * Manager OR HR
             */
            $table->unsignedTinyInteger('rating')
                ->nullable();

            $table->text('comments')
                ->nullable();

            $table->timestamp('reviewed_at')
                ->nullable();

            $table->timestamps();

            $table->index([
                'goal_self_report_id',
                'reviewer_type',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goal_report_reviews');
    }
};