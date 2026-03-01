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
        Schema::create('faculty_retentions_remarks', function (Blueprint $table) {
            $table->id();

            // Relation with parent table
            $table->unsignedBigInteger('faculty_retention_id');

            // Your fields
            $table->unsignedBigInteger('faculty_id');
            $table->string('no_retention_rate')->nullable();
            $table->text('remarks')->nullable();

            $table->enum('status', ['1', '2', '3', '4', '5', '6'])->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculty_retentions_remarks');
    }
};
