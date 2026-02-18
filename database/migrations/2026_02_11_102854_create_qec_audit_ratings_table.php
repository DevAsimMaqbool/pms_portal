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
        Schema::create('qec_audit_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id');
            $table->unsignedBigInteger('user_id'); // created by
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER', 'ORIC', 'HR'])->default('RESEARCHER');
            $table->enum('status', ['1', '2', '3', '4', '5', '6'])->default('1');
            $table->text('remarks');
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
        Schema::dropIfExists('qec_audit_ratings');
    }
};
