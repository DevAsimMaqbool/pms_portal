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
        Schema::table('satisfaction_of_international_students', function (Blueprint $table) {
            $table->enum('reject_status', ['0','1','2','3'])->default('0')->after('update_history');
            $table->string('reject_status_remarks')->nullable()->after('reject_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('satisfaction_of_international_students', function (Blueprint $table) {
            $table->dropColumn(['reject_status', 'reject_status_remarks']);
        });
    }
};
