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
        Schema::create('employee_tasks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employee_id');

            $table->date('task_date');

            $table->string('task_title');

            $table->text('task_description')->nullable();

            $table->enum('planned_type', ['Planned', 'unplanned']);

            $table->date('planned_start_date')->nullable();

            $table->date('planned_end_date')->nullable();

            $table->time('actual_start_time');

            $table->time('actual_end_time');

            $table->decimal('hours_worked', 8,2)->nullable();

            $table->decimal('estimated_hours', 8,2)->nullable();

            $table->string('location')->nullable();

            $table->unsignedBigInteger('kpa_id');

            $table->unsignedBigInteger('kpi_id');

            $table->unsignedBigInteger('goal_id');

            $table->integer('self_completion')->default(0);

            $table->string('status')->nullable();

            $table->text('output_deliverables')->nullable();

            $table->string('nature_of_task')->nullable();

            $table->string('priority')->nullable();

            $table->string('ownership')->nullable();

            $table->string('attachment')->nullable();

            $table->enum('task_status', ['1', '2', '3', '4', '5', '6'])->default('1');

            $table->enum('reject_status', ['0','1','2','3'])->default('0');
            $table->string('reject_status_remarks')->nullable();
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
        Schema::dropIfExists('employee_tasks');
    }
};
