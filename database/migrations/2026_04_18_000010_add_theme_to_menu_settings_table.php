<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('menu_settings', 'theme')) {
                $table->string('theme', 50)->default('classy')->after('is_public');
            }
        });
    }

    public function down(): void
    {
        Schema::table('menu_settings', function (Blueprint $table) {
            if (Schema::hasColumn('menu_settings', 'theme')) {
                $table->dropColumn('theme');
            }
        });
    }
};
