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
        Schema::create('faculties', function (Blueprint $table) {
            // use same ID from Excel, not auto-incremented
            $table->unsignedBigInteger('id')->primary();

            $table->string('code')->nullable();
            $table->string('name');
            $table->unsignedBigInteger('campus_id'); // FK reference
            $table->string('phone')->nullable();
            $table->string('website')->nullable();

            $table->timestamps();

            // foreign key constraint
            $table->foreign('campus_id')
                ->references('id')
                ->on('campuses')
                ->onDelete('cascade'); // or setNull if preferred
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};
