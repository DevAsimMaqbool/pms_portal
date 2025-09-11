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
        Schema::create('spin_offs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kpa_id');
            $table->unsignedBigInteger('sp_category_id');
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN','OTHER'])->default('RESEARCHER');
            $table->string('name_of_faculty_member')->nullable();
            $table->string('spin_off_form_submission')->nullable();
            $table->string('status_of_spin_off_feasibility')->nullable();
            $table->string('work_plan_for_the_spin_off')->nullable();
            $table->string('name_of_pre_spin_off')->nullable();
            $table->string('total_revenue_generated')->nullable();
            $table->string('annual_revenue_generated')->nullable();
            $table->string('rev_current_financial_year')->nullable();
            $table->string('target_of_new_spin_offs')->nullable();
            $table->string('target_of_pre_spin_offs')->nullable();
            $table->string('name_of_lead_faculty_member')->nullable();
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
        Schema::dropIfExists('spin_off');
    }
};
