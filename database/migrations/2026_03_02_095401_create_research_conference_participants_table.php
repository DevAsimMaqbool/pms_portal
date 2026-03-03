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
        Schema::create('research_conference_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('research_conference_impact_id');
            $table->string('name');
            $table->string('designation');
            $table->string('participant_university');
            $table->string('participant_country');

            $table->text('participated_as');
            $table->enum('status', ['1', '2', '3', '4', '5', '6'])->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_conference_participants');
    }
};
