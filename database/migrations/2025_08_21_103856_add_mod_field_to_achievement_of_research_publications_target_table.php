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
        Schema::table('achievement_of_research_publications_target', function (Blueprint $table) {
            $table->unsignedBigInteger('faculty_member_id')->nullable()->after('id');
            $table->boolean('capacity_building')->nullable()->after('status'); 
            $table->string('need')->nullable()->after('capacity_building');
            $table->text('any_specifics_related_to_capacity_building')->nullable()->after('need');
            $table->integer('frequency')->nullable()->after('any_specifics_related_to_capacity_building');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN','OTHER'])->default('RESEARCHER')->after('frequency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievement_of_research_publications_target', function (Blueprint $table) {
            $table->dropColumn([
                'faculty_member_id',
                'capacity_building',
                'need',
                'any_specifics_related_to_capacity_building',
                'frequency',
                'form_status'
            ]);
        });
    }
};
