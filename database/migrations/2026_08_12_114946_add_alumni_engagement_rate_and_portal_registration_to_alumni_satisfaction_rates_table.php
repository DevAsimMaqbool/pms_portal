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
        Schema::table('alumni_satisfaction_rates', function (Blueprint $table) {
            $table->decimal('alumni_engagement_rate')
                ->nullable()
                ->after('satisfaction_rate');

            $table->decimal('portal_registration')
                ->nullable()
                ->after('alumni_engagement_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumni_satisfaction_rates', function (Blueprint $table) {
            $table->dropColumn([
                'alumni_engagement_rate',
                'portal_registration',
            ]);
        });
    }
};
