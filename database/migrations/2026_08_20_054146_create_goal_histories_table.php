<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('goal_histories', function (Blueprint $table) {

            $table->id();

            /*
             * New Goal
             */
            $table->foreignId('goal_id')
                ->constrained('new_goals')
                ->cascadeOnDelete();

            /*
             * Person who performed action
             */
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
             * Action
             */
            $table->string('action');

            /*
             * Status transition
             */
            $table->string('from_status')
                ->nullable();

            $table->string('to_status')
                ->nullable();

            /*
             * Comments from manager / HR
             */
            $table->text('comments')
                ->nullable();

            /*
             * Extra information
             *
             * report_id
             * rating
             * manager_rating
             * hr_rating
             * decision
             * etc.
             */
            $table->json('metadata')
                ->nullable();

            $table->timestamps();

            $table->index([
                'goal_id',
                'created_at',
            ]);

            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goal_histories');
    }
};