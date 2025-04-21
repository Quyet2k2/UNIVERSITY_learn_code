<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class ReportController extends Controller
{
 /**
  * Hiển thị danh sách báo cáo KPI của nhân viên, kèm tính năng tìm kiếm
  */
 public function index(Request $request)
 {
  $users = User::all();
  $query = Task::where('status', 'Completed');

  if ($request->filled('user_id')) {
   $query->where('assigned_to', $request->user_id);
  }
  $reports = $query->selectRaw('assigned_to, SUM(COALESCE(bill, 0)) as total_kpi, COUNT(id) as total_tasks')
   ->groupBy('assigned_to')
   ->with('assignedUser')
   ->paginate(10);

  return view('pages.user.reports.index', compact('reports', 'users'));
 }

 /**
  * Hiển thị báo cáo KPI chi tiết của một nhân viên theo tháng
  */
 public function userReport(Request $request, $userId)
 {
  $user = User::findOrFail($userId);

  // Lấy danh sách task đã hoàn thành của nhân viên này
  $query_task = Task::where('assigned_to', $userId)
   ->where('status', 'Completed');
  // Tính tổng KPI theo tháng
  $query_report = Task::where('assigned_to', $userId)
   ->where('status', 'Completed');

  // Lọc theo tháng
  if ($request->filled('month')) {
   $query_task->whereMonth('first_completed_at', $request->month);

   $query_report->whereMonth('first_completed_at', $request->month);
  }

  // Lọc theo năm
  if ($request->filled('year')) {
   $query_task->whereYear('first_completed_at', $request->year);

   $query_report->whereYear('first_completed_at', $request->year);
  }

  // Lấy danh sách task chi tiết
  $tasks = $query_task->select('id', 'name', 'bill', 'first_completed_at')
   ->orderBy('first_completed_at', 'desc')
   ->get();

  // Tính tổng KPI theo tháng
  $report = $query_report->selectRaw("
            DATE_FORMAT(first_completed_at, '%Y-%m') as period, 
            SUM(COALESCE(bill, 0)) as total_kpi
        ")
   ->groupBy('period')
   ->orderBy('period', 'desc')
   ->get();

  // Tổng KPI của tất cả task
  $totalKpi = $tasks->sum('bill');

  return view('pages.user.reports.user', compact('user', 'report', 'tasks', 'totalKpi'));
 }
}
