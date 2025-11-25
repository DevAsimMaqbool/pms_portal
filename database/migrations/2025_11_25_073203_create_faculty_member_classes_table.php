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
        Schema::create('faculty_member_classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->unsignedBigInteger('class_id')->nullable();
            $table->string('class_name')->nullable();
            $table->string('code')->nullable();
            $table->unsignedBigInteger('term_id')->nullable();
            $table->string('term')->nullable();
            $table->unsignedBigInteger('career_id')->nullable();
            $table->string('career')->nullable();
            $table->string('career_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculty_member_classes');
    }
};
