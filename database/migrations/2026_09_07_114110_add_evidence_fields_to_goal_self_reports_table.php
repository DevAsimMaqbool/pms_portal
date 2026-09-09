<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('goal_self_reports', function (Blueprint $table) {

            $table->enum('evidence_type', ['video', 'attachment'])
                ->nullable()
                ->after('hr_rating');

            $table->text('evidence_video_url')
                ->nullable()
                ->after('evidence_type');

            $table->string('evidence_attachment')
                ->nullable()
                ->after('evidence_video_url');

        });
    }

    public function down(): void
    {
        Schema::table('goal_self_reports', function (Blueprint $table) {

            $table->dropColumn([
                'evidence_type',
                'evidence_video_url',
                'evidence_attachment',
            ]);

        });
    }
};