<?php

namespace Database\Seeders;

use App\Models\AttendanceLog;
use Illuminate\Database\Seeder;

class AttendanceLogSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['Aarav Sharma','EMP-1001','2025-09-22','9:00 AM - 6:00 PM','8h 45m','9h 10m','On Time','Present'],
            ['Priya Patel','EMP-1002','2025-09-22','9:00 AM - 6:00 PM','7h 30m','8h 05m','Late by 22m','Late'],
            ['Rohan Verma','EMP-1003','2025-09-22','10:00 AM - 7:00 PM','8h 10m','8h 50m','On Time','Present'],
            ['Sneha Iyer','EMP-1004','2025-09-22','9:00 AM - 6:00 PM','0h','0h','—','Leave'],
            ['Karan Mehta','EMP-1005','2025-09-22','9:00 AM - 6:00 PM','8h 55m','9h 25m','On Time','Present'],
            ['Aarav Sharma','EMP-1001','2025-09-21','—','—','—','—','Weekly-off'],
            ['Priya Patel','EMP-1002','2025-09-19','9:00 AM - 6:00 PM','9h 05m','9h 40m','On Time','Present'],
            ['Rohan Verma','EMP-1003','2025-09-19','10:00 AM - 7:00 PM','0h','0h','—','Absent'],
            ['Sneha Iyer','EMP-1004','2025-09-19','9:00 AM - 6:00 PM','8h 20m','8h 55m','Late by 8m','Late'],
            ['Karan Mehta','EMP-1005','2025-09-19','9:00 AM - 6:00 PM','8h 40m','9h 15m','On Time','Present'],
        ];

        foreach ($rows as $r) {
            AttendanceLog::create([
                'employee_name'  => $r[0],
                'employee_code'  => $r[1],
                'log_date'       => $r[2],
                'shift'          => $r[3],
                'effective_hours'=> $r[4],
                'gross_hours'    => $r[5],
                'arrival'        => $r[6],
                'status'         => $r[7],
            ]);
        }
    }
}
