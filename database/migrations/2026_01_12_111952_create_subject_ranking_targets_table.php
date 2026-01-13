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
        Schema::create('subject_ranking_targets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER', 'ORIC', 'HR'])->default('RESEARCHER');

            $table->string('academic_year');
            $table->string('faculty_id');
            $table->string('department_id');
            $table->string('subject_id');

            $table->string('ranking_body')->nullable();

            $table->integer('targeted_ranking_range');
            $table->string('actual_ranking_achieved'); // numeric / not_ranked
            $table->string('ranking_status'); // achieved / partially / not

            $table->string('evidence_upload')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('subject_ranking_targets');
    }
};
