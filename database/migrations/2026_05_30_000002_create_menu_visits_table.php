<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_visits', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('menu_setting_id')->nullable()->constrained()->nullOnDelete();
            $table->date('visited_on')->index();
            $table->timestamp('visited_at')->index();
            $table->char('visitor_hash', 64)->index();
            $table->char('ip_hash', 64)->nullable();
            $table->char('user_agent_hash', 64)->nullable();
            $table->string('device_type', 20)->default('unknown')->index();
            $table->string('source', 40)->nullable()->index();
            $table->string('path', 255)->nullable();
            $table->text('referer')->nullable();
            $table->timestamps();

            $table->index(['restaurant_id', 'visited_on']);
            $table->index(['restaurant_id', 'visitor_hash', 'visited_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_visits');
    }
};
