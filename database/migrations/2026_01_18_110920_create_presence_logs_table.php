<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('presence_logs', function (Blueprint $table) {
            $table->id();

            $table->string('device_uuid', 64);
            $table->enum('event', ['IN', 'OUT']);
            $table->integer('rssi')->nullable();
            $table->string('source')->nullable(); // esp32-1, gate-A, etc

            $table->timestamp('detected_at')->useCurrent();

            $table->timestamps();

            $table->index('device_uuid');
            $table->index('detected_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presence_logs');
    }
};
