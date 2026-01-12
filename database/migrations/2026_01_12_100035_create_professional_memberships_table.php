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
        Schema::create('professional_memberships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER', 'ORIC', 'HR'])->default('RESEARCHER');

            $table->string('type_of_membership'); // individual_faculty / institutional
            $table->string('name_of_professional_body');
            $table->string('category_of_body'); // academic/professional/research/accreditation
            $table->string('discipline');
            $table->string('level'); // national / international
            $table->string('country')->nullable(); // if international
            $table->string('membership_status'); // new / renewed
            $table->date('membership_start_date');
            $table->date('membership_valid_until');

            $table->json('evidence_type')->nullable(); // certificate, email_confirmation, invoice, MOU
            $table->string('document_link')->nullable();
            $table->boolean('declaration')->default(false);
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
        Schema::dropIfExists('professional_memberships');
    }
};
