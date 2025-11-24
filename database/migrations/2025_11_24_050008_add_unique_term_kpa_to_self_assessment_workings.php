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
        Schema::table('self_assessment_workings', function (Blueprint $table) {
            $table->unique(['term', 'kpa'], 'unique_term_kpa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('self_assessment_workings', function (Blueprint $table) {
            $table->dropUnique('unique_term_kpa');
        });
    }
};
