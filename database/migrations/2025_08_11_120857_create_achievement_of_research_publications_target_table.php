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
        Schema::create('achievement_of_research_publications_target', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kpa_id');
            $table->unsignedBigInteger('sp_category_id');
            $table->unsignedBigInteger('indicator_id');

            $table->string('target_category')->nullable();
            $table->string('target_of_publications')->nullable();
            $table->string('draft_stage')->nullable();
            $table->string('email_screenshot')->nullable();
            $table->string('scopus_link')->nullable();
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
        Schema::dropIfExists('achievement_of_research_publications_target');
    }
};
