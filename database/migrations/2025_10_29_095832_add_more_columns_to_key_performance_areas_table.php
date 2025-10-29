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
        Schema::table('key_performance_areas', function (Blueprint $table) {
             $table->string('icon')->nullable()->after('performance_area'); // or after any existing column
            $table->string('short_code')->nullable()->after('icon');
            $table->string('slug')->nullable()->after('short_code');
            $table->text('small_description')->nullable()->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('key_performance_areas', function (Blueprint $table) {
            $table->dropColumn(['icon', 'short_code', 'slug', 'small_description']);
        });
    }
};
