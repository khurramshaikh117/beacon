<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name');
            $table->string('employee_code')->index();
            $table->date('log_date');
            $table->string('shift')->nullable();
            $table->string('effective_hours')->nullable();
            $table->string('gross_hours')->nullable();
            $table->string('arrival')->nullable();
            $table->string('status'); // Present, Late, Absent, Leave, Weekly-off
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
    }
};