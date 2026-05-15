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
       Schema::create('presence_logs', function (Blueprint $table) {
            $table->id();

            $table->uuid('device_uuid');
            $table->uuid('user_uuid')->nullable();

            $table->integer('rssi')->nullable();

            $table->integer('status')->index(); // 1001 active, 1002 inactive

            $table->timestamps();

            // Indexes for fast lookup
            $table->index('device_uuid');
            $table->index('user_uuid');
            $table->index('created_at');
            $table->foreign('device_uuid')->references('uuid')->on('devices')->cascadeOnDelete();
            $table->foreign('user_uuid')->references('user_uuid')->on('platform_users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presence_logs');
    }
};
