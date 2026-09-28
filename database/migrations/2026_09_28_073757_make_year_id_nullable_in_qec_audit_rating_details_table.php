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
        Schema::table('qec_audit_rating_details', function (Blueprint $table) {
             $table->unsignedBigInteger('year_id')->nullable()->after('area_of_improvement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qec_audit_rating_details', function (Blueprint $table) {
            $table->dropColumn([
                'year_id',
            ]);
        });
    }
};
