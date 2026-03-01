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
        Schema::create('sidebar_kpa_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->unsignedInteger('key_performance_area_id');
            $table->string('kpa_weightage', 10)->nullable();

            $table->unsignedInteger('indicator_category_id');
            $table->string('indicator_category_weightage', 10)->nullable();

            $table->unsignedInteger('indicator_id');
            $table->string('indicator_weightage', 10)->nullable();

            $table->integer('form_status')->default(0);

            $table->enum('status', ['0', '1', '2'])->default('0');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sidebar_kpa_assignments');
    }
};
