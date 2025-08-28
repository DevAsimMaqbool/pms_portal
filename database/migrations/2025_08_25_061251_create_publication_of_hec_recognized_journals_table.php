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
        Schema::create('publication_of_hec_recognized_journals', function (Blueprint $table) {
            $table->id();
            // Hidden input fields
            $table->unsignedBigInteger('kpa_id');
            $table->unsignedBigInteger('sp_category_id');
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN','OTHER'])->default('RESEARCHER');

            // Form fields
            $table->string('name_of_journal')->nullable();
            $table->string('approved_frequency_of_pub')->nullable();
            $table->string('no_of_issues_published')->nullable();
            $table->string('revenue_generated_under_apc')->nullable();
            $table->string('no_of_indexing_prior_report')->nullable();
            $table->string('new_indexing_done_quarter')->nullable();
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
        Schema::dropIfExists('publication_of_hec_recognized_journals');
    }
};
