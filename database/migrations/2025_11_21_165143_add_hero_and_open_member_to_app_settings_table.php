<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('app_settings', function (Blueprint $table) {
            $table->string('hero_background')->nullable()->after('theme');
            $table->boolean('is_open_member')->default(true)->after('hero_background');
        });
    }

    public function down(): void
    {
        Schema::table('app_settings', function (Blueprint $table) {
            $table->dropColumn('hero_background');
            $table->dropColumn('is_open_member');
        });
    }
};