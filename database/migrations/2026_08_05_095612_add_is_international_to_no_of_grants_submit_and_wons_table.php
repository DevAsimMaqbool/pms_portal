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
        Schema::table('no_of_grants_submit_and_wons', function (Blueprint $table) {
            $table->boolean('is_international')
                ->default(false)
                ->after('grant_status'); // Change the column name if needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('no_of_grants_submit_and_wons', function (Blueprint $table) {
            $table->dropColumn('is_international');
        });
    }
};
