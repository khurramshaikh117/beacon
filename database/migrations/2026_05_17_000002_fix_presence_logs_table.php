<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('presence_logs', function (Blueprint $table) {
            // Drop broken FK to platform_users
            $table->dropForeign(['user_uuid']);

            // Add zone column
            $table->string('zone')->nullable()->after('user_uuid');
        });
    }

    public function down(): void
    {
        Schema::table('presence_logs', function (Blueprint $table) {
            $table->dropColumn('zone');
        });
    }
};