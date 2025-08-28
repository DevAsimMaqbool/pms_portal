<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('roll_number', 25);
            $table->string('full_name', 100);
            $table->string('father_name', 50);
            $table->string('email', 75);
            $table->string('cnic', 15);
            $table->string('mobile_number', 15);
            $table->timestamp('email_verified_at')->default(DB::raw('CURRENT_TIMESTAMP'))->useCurrentOnUpdate();
            $table->string('password');
            $table->string('profile_image');
            $table->string('two_factor_code', 10);
            $table->dateTime('two_factor_expires_at');
            $table->rememberToken(); // Equivalent to varchar(100)
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps(); // created_at and updated_at
            $table->timestamp('deleted_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
