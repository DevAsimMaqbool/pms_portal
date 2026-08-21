<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('goal_histories', function (Blueprint $table) {

            $table->foreignId('new_goal_id')
                ->after('id')
                ->constrained('new_goals')
                ->cascadeOnDelete();

            $table->index(['new_goal_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('goal_histories', function (Blueprint $table) {

            $table->dropForeign(['new_goal_id']);
            $table->dropIndex(['new_goal_id', 'created_at']);
            $table->dropColumn('new_goal_id');

        });
    }
};