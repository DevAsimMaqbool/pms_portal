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
        Schema::table('employabilities', function (Blueprint $table) {
             $table->string('employer_name', 191)
                ->nullable()
                ->change();
             $table->string('student_id', 191)
                ->nullable()
                ->change();   

            $table->string('sector', 191)
                ->nullable()
                ->change();

            $table->unsignedInteger('salary')
                ->nullable()
                ->change();

            $table->enum('market_competitive_salary', [
                'Above',
                'At Par',
                'Low'
            ])
                ->nullable()
                ->change();

            $table->enum('job_relevancy', [
                'yes',
                'no'
            ])
                ->nullable()
                ->default('no')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employabilities', function (Blueprint $table) {
            $table->string('employer_name', 191)
                ->nullable(false)
                ->change();

            $table->string('sector', 191)
                ->nullable(false)
                ->change();

            $table->integer('salary')
                ->nullable(false)
                ->change();

            $table->enum('market_competitive_salary', [
                'Above',
                'At Par',
                'Low'
            ])
                ->nullable(false)
                ->change();

            $table->enum('job_relevancy', [
                'yes',
                'no'
            ])
                ->nullable(false)
                ->default('no')
                ->change();
             $table->unsignedBigInteger('student_id')
                ->nullable()
                ->change();    
        });
    }
};
