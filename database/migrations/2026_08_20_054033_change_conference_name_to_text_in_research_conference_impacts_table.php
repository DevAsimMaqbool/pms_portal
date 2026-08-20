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
        Schema::table('research_conference_impacts', function (Blueprint $table) {
            $table->text('conference_name')->change();
            $table->text('conference_theme')->change();
            $table->text('conference_venue')->change();
            $table->text('partner_institute')->change();
            $table->unsignedBigInteger('year_id')->after('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('research_conference_impacts', function (Blueprint $table) {
            $table->string('conference_name')->change();
            $table->string('conference_theme')->change();
            $table->string('conference_venue')->change();
            $table->string('partner_institute')->change();
            $table->dropColumn('year_id');
        });
    }
};
