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
        Schema::create('products_delivered_to_industries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER'])->default('RESEARCHER');
            $table->string('project_name')->nullable();
            $table->string('other_disciplines')->nullable();
            $table->string('partner_industry')->nullable();
            $table->string('identified_public_sector_entity')->nullable();
            $table->string('completion_time_of_project')->nullable();
            $table->enum('product_developed', ['YES', 'NO', 'NA'])->default('NO');
            $table->enum('third_party_validation', ['YES', 'NO', 'NA'])->default('NO');
            $table->enum('ip_claim', ['YES', 'NO'])->default('NO');
            $table->string('provide_details')->nullable();
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
        Schema::dropIfExists('products_delivered_to_industries');
    }
};
