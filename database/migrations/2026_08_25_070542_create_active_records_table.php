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
        Schema::create('active_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('year_id')->nullable();
            $table->unsignedTinyInteger('term_spring_id')->nullable();
            $table->unsignedTinyInteger('term_fall_id')->nullable();
            $table->text('description')->nullable();
            $table->boolean('status_year')->default(1);
            $table->boolean('status_spring')->default(1);
            $table->boolean('status_fall')->default(1);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('active_records');
    }
};
