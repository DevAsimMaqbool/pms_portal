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
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->string('goal_name');
            $table->string('goal_cod')->nullable();

            $table->foreignId('s2r_driver_id')
                ->nullable()
                ->constrained('s2_r_drivers')
                ->nullOnDelete();

            $table->text('goal_statement')->nullable();
            $table->enum('validate', ['1', '2', '3', '4', '5', '6'])->default('1');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
