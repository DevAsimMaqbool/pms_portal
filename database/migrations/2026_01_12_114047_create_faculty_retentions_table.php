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
        Schema::create('faculty_retentions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER', 'ORIC', 'HR'])->default('RESEARCHER');

            $table->string('academic_year');
            $table->string('faculty_id');
            $table->string('department_id');

            $table->integer('strength_at_start_of_month');
            $table->integer('join_during_month');
            $table->integer('left_during_month');
            $table->integer('strength_end_month');

            $table->decimal('retention_rate', 5, 2); // e.g., 95.50%
            $table->string('retention_status'); // excellent / satisfactory / needs_attention

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
        Schema::dropIfExists('faculty_retentions');
    }
};
