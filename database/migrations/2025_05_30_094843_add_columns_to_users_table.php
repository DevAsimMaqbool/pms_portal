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
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender', '6')->nullable()->after('name');
            $table->string('marital', '10')->nullable()->after('gender');
            $table->string('birthday', '20')->nullable()->after('marital');
            $table->string('cnic', '20')->nullable()->after('birthday');
            $table->string('emergency_phone', '15')->nullable()->after('cnic');
            $table->string('barcode', '10')->nullable()->after('emergency_phone');
            $table->string('job_title')->nullable()->after('barcode');
            $table->string('work_phone', '15')->nullable()->after('job_title');
            $table->string('mobile_phone', '15')->nullable()->after('work_phone');
            $table->string('work_location')->nullable()->after('mobile_phone');
            $table->string('blood_group', '10')->nullable()->after('work_location');
            $table->string('department_id', '15')->nullable()->after('department');
            $table->string('manager_name')->nullable()->after('manager_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['gender', 'marital', 'birthday', 'cnic', 'emergency_phone', 'barcode', 'job_title', 'work_phone', 'mobile_phone', 'work_location', 'blood_group', 'department_id', 'manager_name']);
        });
    }
};
