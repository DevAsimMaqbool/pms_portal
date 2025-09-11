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
        Schema::create('trainings_seminars_workshop_conducted_with_impact', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kpa_id');
            $table->unsignedBigInteger('sp_category_id');
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN','OTHER'])->default('RESEARCHER');
            $table->string('ket_target')->nullable();
            $table->string('target_of_ken_knowledge_products')->nullable();
            $table->string('event_proposal_forms_submission')->nullable();
            $table->string('no_of_knowledge_products_produced')->nullable();
            $table->string('no_of_participants')->nullable();
            $table->string('no_of_participants_from_the_industry')->nullable();
            $table->string('no_of_participants_from_the_public_sector')->nullable();
            $table->enum('status', ['1', '2', '3'])->default('1');
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
        Schema::dropIfExists('trainings_seminars_workshop_conducted_with_impact');
    }
};
