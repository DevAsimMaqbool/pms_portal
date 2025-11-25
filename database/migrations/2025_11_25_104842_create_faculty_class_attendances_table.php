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
        Schema::create('faculty_class_attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id')->nullable();
            $table->date('class_date')->nullable();
            $table->string('total_students')->nullable();
            $table->string('present_count')->nullable();
            $table->string('absent_count')->nullable();
            $table->string('present_percentage')->nullable();
            $table->string('absent_percentage')->nullable();
            $table->string('color')->nullable();
            $table->string('rating')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculty_class_attendances');
    }
};
