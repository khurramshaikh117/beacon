<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    protected $fillable = [
        'employee_name', 'employee_code', 'log_date', 'shift',
        'effective_hours', 'gross_hours', 'arrival', 'status',
    ];

    protected $casts = ['log_date' => 'date'];
}
