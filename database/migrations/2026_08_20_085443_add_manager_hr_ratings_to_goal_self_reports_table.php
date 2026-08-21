<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('goal_self_reports', function (Blueprint $table) {

            $table->unsignedTinyInteger('manager_rating')
                ->nullable()
                ->after('rating');

            $table->unsignedTinyInteger('hr_rating')
                ->nullable()
                ->after('manager_rating');

            $table->timestamp('manager_reviewed_at')
                ->nullable()
                ->after('submitted_at');

            $table->timestamp('hr_reviewed_at')
                ->nullable()
                ->after('manager_reviewed_at');
        });
    }

    public function down(): void
    {
        Schema::table('goal_self_reports', function (Blueprint $table) {

            $table->dropColumn([
                'manager_rating',
                'hr_rating',
                'manager_reviewed_at',
                'hr_reviewed_at',
            ]);

        });
    }
};