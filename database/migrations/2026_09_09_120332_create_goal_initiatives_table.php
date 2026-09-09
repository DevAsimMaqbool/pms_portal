<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goal_initiatives', function (Blueprint $table) {

            $table->id();

            // Employee who created the initiative
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Initiative details
            $table->string('title');

            $table->date('from_date');
            $table->date('to_date');

            $table->string('nature_of_initiative');
            $table->string('nature_other')->nullable();

            $table->enum('scope', [
                'individual',
                'team_peer',
                'departmental',
                'faculty_wide',
                'institution_wide',
            ]);

            $table->text('description');

            // Initiative status
            $table->enum('status', [
                'idea_designed_only',
                'approved_in_progress',
                'completed',
                'completed_verified',
            ]);

            // Outcome
            $table->text('outcome')->nullable();

            // Impact
            $table->text('impact_reach')->nullable();
            $table->text('impact_outcome')->nullable();

            // Sustainability
            $table->enum('sustainability', [
                'one_off',
                'adopted_standard_practice',
            ])->nullable();

            $table->text('sustainability_field')->nullable();

            // Strategic alignment
            $table->enum('strategic_alignment', [
                'not_linked',
                'linked',
            ])->nullable();

            $table->text('strategic_goal')->nullable();

            // Supervisor / Project Head
            $table->string('supervisor_name')->nullable();
            $table->string('supervisor_designation')->nullable();
            $table->string('supervisor_department')->nullable();

            // Evidence
            $table->string('evidence_attachment')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Manager Validation
            |--------------------------------------------------------------------------
            |
            | submitted  = Waiting for manager
            | approved   = Manager approved
            | amended   = Manager approved with amendment
            | rejected   = Manager rejected
            |
            */
            $table->enum('manager_decision', [
                'submitted',
                'approved',
                'approved_with_amendment',
                'rejected',
            ])->default('submitted');

            // Manager remarks / amendment details
            $table->text('manager_remarks')->nullable();

            // Manager who made the decision
            $table->foreignId('manager_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('submitted_at')->nullable();

            $table->timestamp('manager_decided_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goal_initiatives');
    }
};