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
        Schema::create('alumni_contributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER', 'ORIC', 'HR'])->default('RESEARCHER');

            $table->string('academic_year');
            $table->string('alumni_name');
            $table->year('graduation_year');
            $table->string('faculty_id');
            $table->json('type_of_contribution')->nullable(); // multiple selections
            $table->text('description_of_contribution')->nullable();
            $table->date('date_of_contribution');

            $table->string('evidence_upload')->nullable();
            $table->string('contribution_verified_by')->nullable();
            $table->string('verification_status')->nullable();

            $table->enum('status', ['1', '2', '3', '4', '5', '6'])->default('1');
            $table->json('update_history')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni_contributions');
    }
};
