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
        Schema::table('line_manager_feedback', function (Blueprint $table) {
            $table->json('strength')->nullable()->after('inspirational_leadership_2');
            $table->json('area_of_improvement')->nullable()->after('strength');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('line_manager_feedback', function (Blueprint $table) {
            $table->dropColumn(['strength', 'area_of_improvement']);
        });
    }
};
