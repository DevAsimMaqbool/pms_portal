<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('goal_histories', function (Blueprint $table) {
            $table->dropForeign(['goal_id']);
            $table->dropColumn('goal_id');
        });
    }

    public function down(): void
    {
        Schema::table('goal_histories', function (Blueprint $table) {
            $table->foreignId('goal_id')
                ->constrained('goals')
                ->cascadeOnDelete();
        });
    }
};