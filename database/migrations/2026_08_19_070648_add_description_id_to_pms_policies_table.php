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
        Schema::table('pms_policies', function (Blueprint $table) {
            $table->string('sop_name')->after('id');
            $table->text('description')->nullable()->after('sop_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pms_policies', function (Blueprint $table) {
            $table->dropColumn(['sop_name', 'description']);
        });
    }
};
