<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'number_of_knowledge_products',
            'commercial_gains_counsultancy_research_incomes',
            'industrial_visits',
            'industrial_projects',
            'intellectual_properties',
            'professional_memberships',
            'no_of_programs_accredited',
            'no_achievement_of_multidisciplinary_projects_targets',
            'no_of_grants_submit_and_wons',
            'products_delivered_to_industries',
            'achievement_of_research_publications_target',
            'indicators_percentages'
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->unsignedBigInteger('year_id')
                    ->nullable()
                    ->before('created_at');
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'number_of_knowledge_products',
            'commercial_gains_counsultancy_research_incomes',
            'industrial_visits',
            'industrial_projects',
            'intellectual_properties',
            'professional_memberships',
            'no_of_programs_accredited',
            'no_achievement_of_multidisciplinary_projects_targets',
            'no_of_grants_submit_and_wons',
            'products_delivered_to_industries',
            'achievement_of_research_publications_target',
            'indicators_percentages'
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('year_id');
            });
        }
    }
};
