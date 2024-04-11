<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Visit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    /* Thống kê truy cập website */
    public function dashboard()
    {
        session(['module_active' => 'dashboard']);
        if (!empty(request()->get('year')) && !empty(request()->get('month'))) {
            $time = request()->get('year') . '-' . request()->get('month') . '-1';
            $date = strtotime($time);
        } else {
            $date = strtotime(date('y-m-d'));
        }
        $month = date('m', $date);
        $year = date('Y', $date);
        $daysInMonth = cal_days_in_month(0, $month, $year);
        $charts = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $k = $i + 1;
            $start = strtotime($year . '-' . $month . '-' . $i);
            $end = strtotime($year . '-' . $month . '-' . $k);
            $todayRecord = Visit::whereBetween('tm', [$start, $end])->get();
            $countTodayRecord = $todayRecord->count();
            $todayVisitors = $countTodayRecord;
            $charts['series'][] = $todayVisitors;
            $charts['labels'][] = 'D' . $i;
        }
        return view('admin.dashboard.index', compact('charts', 'month', 'year'));
    }
}
