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
            $table->string('assessment_type', '20')->nullable()->after('remarks');
            $table->unsignedBigInteger('created_by')->nullable()->after('status');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('line_manager_feedback', function (Blueprint $table) {
            $table->dropColumn(['assessment_type', 'created_by', 'updated_by']);
        });
    }
};
