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
        Schema::create('line_manager_feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable(); // optional: if rating belongs to a user
            $table->integer('responsibility_accountability_1')->nullable();
            $table->integer('responsibility_accountability_2')->nullable();
            $table->integer('empathy_compassion_1')->nullable();
            $table->integer('empathy_compassion_2')->nullable();
            $table->integer('humility_service_1')->nullable();
            $table->integer('humility_service_2')->nullable();
            $table->integer('honesty_integrity_1')->nullable();
            $table->integer('honesty_integrity_2')->nullable();
            $table->integer('inspirational_leadership_1')->nullable();
            $table->integer('inspirational_leadership_2')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_manager_feedback');
    }
};
