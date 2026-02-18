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
        Schema::create('qec_audit_rating_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qec_audit_rating_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('audit_term')->nullable();
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();
            $table->string('program_level')->nullable();
            $table->integer('total_score')->nullable();
            $table->integer('obtained_score')->nullable();
            $table->string('strenght')->nullable();
            $table->string('area_of_improvement')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qec_audit_rating_details');
    }
};
