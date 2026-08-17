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
        Schema::table('employabilities', function (Blueprint $table) {
            $table->string('cnic')->nullable()->after('student_name');
            $table->string('domicile')->nullable()->after('cnic');
            $table->string('gender')->nullable()->after('domicile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employabilities', function (Blueprint $table) {
            $table->dropColumn(['cnic', 'domicile', 'gender']);
        });
    }
};
