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
        Schema::create('international_coauthored_papers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kpa_id');
            $table->unsignedBigInteger('sp_category_id');
            $table->unsignedBigInteger('indicator_id');
            $table->string('name_of_co_authers');
            $table->string('author_rank');
            $table->string('name_of_university_country');
            $table->string('designation')->nullable();
            $table->integer('no_of_papers_past')->default(0);
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN','OTHER'])->default('RESEARCHER');
            $table->enum('status', ['1', '2', '3','4','5','6'])->default('1');
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
        Schema::dropIfExists('international_coauthored_papers');
    }
};
