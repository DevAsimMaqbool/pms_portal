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
        Schema::table('faculty_member_classes', function (Blueprint $table) {
            $table->decimal('passing_percentage', 5, 2)
                ->nullable()
                ->after('average_marks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faculty_member_classes', function (Blueprint $table) {
            $table->dropColumn('passing_percentage');
        });
    }
};
