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
        Schema::table('faculty_net_promoter_scores', function (Blueprint $table) {
            $table->unsignedBigInteger('year_id')->nullable()->after('year');
            $table->unsignedBigInteger('term_id')->nullable()->after('year_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faculty_net_promoter_scores', function (Blueprint $table) {
             $table->dropColumn([
                'year_id',
                'term_id',
            ]);
        });
    }
};
