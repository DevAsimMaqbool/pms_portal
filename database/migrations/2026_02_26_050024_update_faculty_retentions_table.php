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
        Schema::table('faculty_retentions', function (Blueprint $table) {
            // Remove old columns
            $table->dropColumn([
                'faculty_id',
                'no_retention_rate',
                'remarks'
            ]);

            // Add new column
            $table->string('year')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faculty_retentions', function (Blueprint $table) {
            $table->unsignedBigInteger('faculty_id');
            $table->string('no_retention_rate')->nullable();
            $table->text('remarks')->nullable();

            $table->dropColumn('year');
        });
    }
};
