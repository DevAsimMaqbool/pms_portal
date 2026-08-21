<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('new_goals', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->text('goal');

            /*
             * Stores S2R Driver ID
             */
            $table->unsignedBigInteger(
                's2r_driver_enabler_alignment'
            );

            $table->text('objectives')
                ->nullable();

            $table->text('target');

            $table->date('deadline');

            $table->enum('status', [
                'active',
                'completed',
                'cancelled',
            ])->default('active');

            $table->timestamps();

            $table->softDeletes();

            $table->index([
                'user_id',
                'status',
            ]);

            $table->index('deadline');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('new_goals');
    }
};