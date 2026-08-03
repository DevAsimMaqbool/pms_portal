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
        Schema::table('line_manager_review_ratings', function (Blueprint $table) {
            $table->string('kpa_category')->nullable()->after('year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('line_manager_review_ratings', function (Blueprint $table) {
            $table->dropColumn('kpa_category');
        });
    }
};
