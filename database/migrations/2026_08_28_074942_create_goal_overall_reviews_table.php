<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('goal_overall_reviews', function (Blueprint $table) {

            $table->id();

            // Employee whose overall performance is being moderated
            $table->unsignedBigInteger('user_id');

            // HR user
            $table->unsignedBigInteger('reviewer_id');

            // Overall rating provided/confirmed by manager
            $table->unsignedTinyInteger('manager_overall_rating')->nullable();

            // Final HR moderated rating
            $table->unsignedTinyInteger('hr_overall_rating')->nullable();

            $table->enum('decision', [
                'approved',
                'rejected'
            ])->nullable();

            $table->text('comments')->nullable();

            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('reviewer_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->index('user_id');
            $table->index('reviewer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goal_overall_reviews');
    }
};