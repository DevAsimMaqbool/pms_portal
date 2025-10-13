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
        Schema::create('section_wise_surveys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('campus');
            $table->string('faculty');
            $table->string('program');
            $table->string('batch');
            $table->string('section');
            $table->string('course');
            $table->string('component_class');
            $table->string('faculty_member');
            $table->string('feedback');
            $table->string('response_rate');
            $table->string('attempts');
            $table->string('registered_students');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_wise_surveys');
    }
};
