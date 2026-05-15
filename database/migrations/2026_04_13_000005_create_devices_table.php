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
         Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->integer('rssi')->nullable();

            $table->foreignId('last_seen_zone_id')
                ->nullable()
                ->constrained('zones')
                ->nullOnDelete();

            $table->timestamp('last_seen_at')->nullable();

            $table->integer('status')->index(); // 1001 IN, 1002 OUT

            $table->timestamps();

            $table->index(['uuid', 'last_seen_zone_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
