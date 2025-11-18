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
        Schema::create('faculty_targets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id'); // Indicator
            $table->unsignedBigInteger('user_id'); // Faculty member

            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER'])->default('HOD');

            // Scopus targets
            $table->unsignedInteger('scopus_q1')->nullable();
            $table->unsignedInteger('scopus_q2')->nullable();
            $table->unsignedInteger('scopus_q3')->nullable();
            $table->unsignedInteger('scopus_q4')->nullable();

            // HEC targets
            $table->unsignedInteger('hec_w')->nullable();
            $table->unsignedInteger('hec_x')->nullable();
            $table->unsignedInteger('hec_y')->nullable();

            // Medical target
            $table->unsignedInteger('medical_recognized')->nullable();

            // National / International
            $table->unsignedInteger('national')->nullable();
            $table->unsignedInteger('international')->nullable();

            // Optional metadata
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();

            // Foreign keys (optional, if tables exist)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculty_targets');
    }
};
