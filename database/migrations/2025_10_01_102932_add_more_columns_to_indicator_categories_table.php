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
        Schema::table('indicator_categories', function (Blueprint $table) {
            $table->string('cat_icon')->nullable()->after('indicator_category'); // or after any existing column
            $table->string('cat_short_code')->nullable()->after('cat_icon');
            $table->string('cat_slug')->nullable()->after('cat_short_code');
            $table->text('cat_small_description')->nullable()->after('cat_slug');
        });
    }

    /**
     * Reverse the migrations.x1xx1
     */
    public function down(): void
    {
        Schema::table('indicator_categories', function (Blueprint $table) {
             $table->dropColumn(['cat_icon', 'cat_short_code', 'cat_slug', 'cat_small_description']);
        });
    }
};
