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
        Schema::create('self_nominations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable();

            // Awards as JSON arrays
            $table->json('sitara_qiyadat_awards')->nullable();
            $table->text('sitara_qiyadat_why')->nullable();

            $table->json('fakhr_karkardagi_awards')->nullable();
            $table->text('fakhr_karkardagi_why')->nullable();

            $table->json('tamgha_tahqeeq_awards')->nullable();
            $table->text('tamgha_tahqeeq_why')->nullable();

            $table->json('chaudhry_akram_awards')->nullable();
            $table->text('chaudhry_akram_why')->nullable();

            $table->json('service_superheroes_awards')->nullable();
            $table->text('service_superheroes_why')->nullable();

            $table->boolean('disclaimer')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('self_nominations');
    }
};
