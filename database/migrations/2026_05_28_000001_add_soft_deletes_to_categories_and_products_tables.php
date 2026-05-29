<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('categories', 'deleted_at')) {
            Schema::table('categories', function (Blueprint $table): void {
                $table->softDeletes()->after('updated_at');
            });
        }

        if (! Schema::hasColumn('products', 'deleted_at')) {
            Schema::table('products', function (Blueprint $table): void {
                $table->softDeletes()->after('updated_at');
            });
        }
    }

    public function down(): void
    {
        // Intentionally non-destructive: keep soft-delete timestamps for live customer data.
    }
};
