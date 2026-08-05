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
        Schema::table('completion_of_course_folders', function (Blueprint $table) {
            $table->string('document_url')->nullable()->after('class_cod');
            $table->json('completion_status')->nullable()->after('document_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('completion_of_course_folders', function (Blueprint $table) {
             $table->dropColumn([
                'document_url',
                'completion_status'
            ]);
        });
    }
};
