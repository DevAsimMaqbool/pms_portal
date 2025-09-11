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
        Schema::create('no_achievement_of_multidisciplinary_projects_targets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kpa_id');
            $table->unsignedBigInteger('sp_category_id');
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN','OTHER'])->default('RESEARCHER');
            $table->enum('status', ['1', '2', '3'])->default('1');

             $table->string('name_of_project_initiated')->nullable();
            $table->string('other_disciplines_engaged')->nullable();
            $table->string('partner_industry')->nullable();
            $table->string('identified_public_sector_entity')->nullable();
            $table->string('completion_time_of_project')->nullable();
            $table->enum('product_developed', ['YES', 'NO', 'NA'])->default('NO');
            $table->enum('third_party_validation', ['YES', 'NO', 'NA'])->default('NO');
            $table->enum('capacity_building', ['YES', 'NO'])->default('NO');
            $table->string('provide_details')->nullable();


            $table->string('target_of_projects')->nullable();
            $table->string('target_of_faculties')->nullable();
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
        Schema::dropIfExists('no_achievement_of_multidisciplinary_projects_targets');
    }
};
