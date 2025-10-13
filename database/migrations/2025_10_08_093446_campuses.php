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
        Schema::create('campuses', function (Blueprint $table) {
            // Use bigInteger without auto increment for Excel IDs
            $table->unsignedBigInteger('id')->primary();
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('city')->nullable();
            $table->date('effective_date')->nullable();
            $table->text('institutes')->nullable(); // in case multiple institutes are stored as JSON or CSV
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campuses');
    }
};
