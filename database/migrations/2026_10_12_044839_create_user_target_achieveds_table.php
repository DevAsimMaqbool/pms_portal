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
        Schema::create('user_target_achieveds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employ_id');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('indicator_id');
            $table->unsignedBigInteger('year_id');

            $table->decimal('target', 12, 2)->default(0);
            $table->decimal('acheived', 12, 2)->default(0);
            $table->timestamps();
            $table->unique(
                ['employ_id', 'role_id', 'indicator_id', 'year_id'],
                'user_target_achieved_unique'
            );
            $table->enum('status', ['1', '2', '3', '4', '5', '6'])->default('1');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_target_achieveds');
    }
};
