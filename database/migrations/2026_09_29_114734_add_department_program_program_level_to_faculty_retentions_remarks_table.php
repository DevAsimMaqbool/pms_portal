<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faculty_retentions_remarks', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')
                ->after('faculty_id');

            $table->unsignedBigInteger('program_id')
                ->nullable()
                ->after('department_id');

            $table->string('program_level')
                ->nullable()
                ->after('program_id');
        });
    }

    public function down(): void
    {
        Schema::table('faculty_retentions_remarks', function (Blueprint $table) {
            $table->dropColumn([
                'department_id',
                'program_id',
                'program_level',
            ]);
        });
    }
};