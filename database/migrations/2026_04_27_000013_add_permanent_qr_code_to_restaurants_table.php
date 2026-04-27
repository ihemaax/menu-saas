<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('permanent_qr_code', 64)->nullable()->unique()->after('description');
            $table->index('permanent_qr_code');
        });

        DB::table('restaurants')
            ->select(['id', 'permanent_qr_code'])
            ->orderBy('id')
            ->chunkById(100, function ($restaurants): void {
                foreach ($restaurants as $restaurant) {
                    if (! empty($restaurant->permanent_qr_code)) {
                        continue;
                    }

                    do {
                        $code = 'rest_'.Str::lower(Str::random(10));
                        $exists = DB::table('restaurants')
                            ->where('permanent_qr_code', $code)
                            ->exists();
                    } while ($exists);

                    DB::table('restaurants')
                        ->where('id', $restaurant->id)
                        ->update(['permanent_qr_code' => $code]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropIndex(['permanent_qr_code']);
            $table->dropUnique(['permanent_qr_code']);
            $table->dropColumn('permanent_qr_code');
        });
    }
};
