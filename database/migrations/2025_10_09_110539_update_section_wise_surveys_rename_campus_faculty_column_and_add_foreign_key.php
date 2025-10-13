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
        Schema::table('section_wise_surveys', function (Blueprint $table) {
            // ⚠️ Drop existing foreign keys if re-running or adjusting
            if (Schema::hasColumn('section_wise_surveys', 'campus_id')) {
                $table->dropForeign(['campus_id']);
            }
            if (Schema::hasColumn('section_wise_surveys', 'faculty_id')) {
                $table->dropForeign(['faculty_id']);
            }
        });

        Schema::table('section_wise_surveys', function (Blueprint $table) {
            // ✅ Rename existing columns if they exist
            if (Schema::hasColumn('section_wise_surveys', 'campus')) {
                $table->renameColumn('campus', 'campus_id');
            }

            if (Schema::hasColumn('section_wise_surveys', 'faculty')) {
                $table->renameColumn('faculty', 'faculty_id');
            }
        });

        Schema::table('section_wise_surveys', function (Blueprint $table) {
            // ✅ Ensure correct column type (unsignedBigInteger)
            if (Schema::hasColumn('section_wise_surveys', 'campus_id')) {
                $table->unsignedBigInteger('campus_id')->nullable()->change();
            }

            if (Schema::hasColumn('section_wise_surveys', 'faculty_id')) {
                $table->unsignedBigInteger('faculty_id')->nullable()->change();
            }

            // ✅ Add foreign key constraints
            $table->foreign('campus_id')
                ->references('id')
                ->on('campuses')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('faculty_id')
                ->references('id')
                ->on('faculties')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('section_wise_surveys', function (Blueprint $table) {
            // Drop foreign keys first
            if (Schema::hasColumn('section_wise_surveys', 'campus_id')) {
                $table->dropForeign(['campus_id']);
                $table->renameColumn('campus_id', 'campus');
            }

            if (Schema::hasColumn('section_wise_surveys', 'faculty_id')) {
                $table->dropForeign(['faculty_id']);
                $table->renameColumn('faculty_id', 'faculty');
            }
        });
    }
};