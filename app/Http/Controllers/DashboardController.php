<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $query = AttendanceLog::query()->orderByDesc('log_date')->orderBy('employee_name');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('employee_name', 'like', "%{$search}%")
                  ->orWhere('employee_code', 'like', "%{$search}%");
            });
        }

        $logs = $query->paginate(5)->withQueryString();

        $stats = [
            'total_employees' => AttendanceLog::distinct('employee_code')->count('employee_code'),
            'present_today'   => AttendanceLog::where('status', 'Present')->count(),
            'on_leave'        => AttendanceLog::where('status', 'Leave')->count(),
            'late_arrivals'   => AttendanceLog::where('status', 'Late')->count(),
        ];

        return view('dashboard', compact('logs', 'stats', 'search'));
    }
}
