<?php

namespace App\Http\Controllers\User;

use App\Models\Task;
use App\Models\Comment;
use App\Models\Project;
use App\Models\User;
use App\Models\UserProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Home\EmailController;
use Storage;

class TaskController extends Controller
{

 public function index()
 {
  // Xác định truy vấn cơ bản
  $query = Task::query();
  $search_by_task_name = request('search_by_task_name') ?? '';

  // Nếu không phải là admin, lọc theo 'assigned_to'
  if (auth()->user()->id != 1) {
   $query->where('assigned_to', auth()->user()->id);
  }

  // bỏ tasks có trong project Closed
  // $query->whereNotIn('project_id', function ($query) {
  //  $query->select('id')
  //   ->from('projects')
  //   ->where('status', 'Closed');
  // });

  // Lọc theo tên task nếu có tìm kiếm, trừ task đã hoàn thành
  $tasks = $query->where('status', '!=', 'Completed')
   ->where('tasks.name', 'like', '%' . $search_by_task_name . '%')
   ->orderByRaw("FIELD(tasks.status, 'Open', 'Processing', 'Testing', 'PM')")
   ->orderBy('tasks.end_time', 'asc')
   ->paginate(4);

  return view('pages.user.tasks.index', compact('tasks'));
 }

 public function create(Request $request)
 {
  $project_id = $request->query('project_id');
  $projects = Project::all();
  $project = Project::findOrFail($project_id);

  $pm = User::where('id', $project->project_manager_assigned_to)->first();
  $users = $project->users->push($pm)->unique('id'); // Thêm PM + Lọc trùng

  return view('pages.user.tasks.create', compact('projects', 'users', 'project_id'));
 }

 public function store(Request $request)
 {
  $request->validate([
   'project_id' => 'required|exists:projects,id',
   'assigned_to' => 'required|exists:users,id',
   'name' => 'required|max:255',
   'description' => 'nullable',
   'start_time' => 'required|date|date_format:Y-m-d\TH:i',
   'end_time' => 'required|date|date_format:Y-m-d\TH:i|after_or_equal:start_time',
   'bill' => 'required|numeric',
  ]);
  $request['status'] = "Open";

  try {
   $task = Task::create($request->all()); // Nếu có lỗi sẽ ném ra ngoại lệ
  } catch (\Exception $e) {
   return back()->with('error', 'Task creation failed!');
  }

  // Gửi email thống báo cho người dùng được giao task
  $assigned_user = get_user_by_id($request->assigned_to);
  $link = route('user.tasks.show', $task->id);
  if (checkInternetConnection()) // Kiem tra ket noi internet de gui email
   EmailController::taskAssignTo_Notification($assigned_user->email, $link);

  return redirect()->route('user.projects.show', $request->project_id)->with('success', 'Task created successfully!');
 }

 public function show($id)
 {
  $task = Task::findOrFail($id);

  // q-read: Người dùng không là super admin, và không là thành viên dự án, thì không cho phép xem task!
  if (auth()->user()->id != 1 && !in_array(auth()->user()->id, get_user_ids_in_project($task->project_id)))
   return redirect()->route('user.projects.index')->with('error', 'You do not have permission to view this task!');

  $commentsOfTask = Comment::where('task_id', $id)->orderBy('created_at', 'desc')->get();
  $project = get_project_by_id($task->project_id);
  $project_manager_id = $project->project_manager_assigned_to;
  $project_manager = get_user_by_id($project_manager_id);
  $task_status_label = '';  // Đặt màu cho trạng thái task
  switch ($task->status) {
   case 'Open':
    $task_status_label = 'label-primary';
    break;
   case 'Processing':
    $task_status_label = 'label-info';
    break;
   case 'Testing':
    $task_status_label = 'label-warning';
    break;
   case 'PM':
    $task_status_label = 'label-warning';
    break;
   case 'Completed':
    $task_status_label = 'label-danger';
    break;
  }

  return view(
   'pages.user.tasks.show',
   compact(
    'task',
    'commentsOfTask',
    'task_status_label',
    'project_manager',
    'project',
    'project_manager_id'
   )
  );
 }

 public function edit($id)
 {
  $task = Task::findOrFail($id);
  $projects = Project::all();
  $project = Project::findOrFail($task->project_id);

  $pm = User::where('id', $project->project_manager_assigned_to)->first();
  $users = $project->users->push($pm)->unique('id'); // Thêm PM + Lọc trùng
  return view('pages.user.tasks.edit', compact('task', 'projects', 'users'));
 }

 public function update(Request $request, $id)
 {
  // dd($request->all());
  $request->validate([
   'project_id' => 'required|exists:projects,id',
   'assigned_to' => 'required|exists:users,id',
   'name' => 'required|max:255',
   'description' => 'nullable',
   'start_time' => 'required|date|date_format:Y-m-d\TH:i',
   'end_time' => 'required|date|date_format:Y-m-d\TH:i|after_or_equal:start_time',
   'status' => 'required|in:Open,Processing,Testing,PM,Completed',
   'bill' => 'nullable|numeric',
  ]);

  $task = Task::findOrFail($id);
  $old_status = $task->status;
  $old_assigned_to = $task->assigned_to;

  if ($task->first_completed_at == null && $request->status == 'Completed')
   $task->first_completed_at = now();

  if ($task->update($request->all())) {
   // Gửi email thống báo cho người dùng được giao task
   if (
    ($request->status != $old_status
     ||
     $request->assigned_to != $old_assigned_to)
    &&
    $request->status != 'Completed'
   ) {
    $assigned_user = get_user_by_id($request->assigned_to);

    $link = route('user.tasks.show', $task->id);
    if (checkInternetConnection()) // Kiem tra ket noi internet de gui email
     EmailController::taskAssignTo_Notification($assigned_user->email, $link);
   }

   return redirect()->route('user.tasks.show', $task->id)->with('success', 'Task updated successfully!');
  } else {
   return back()->with('error', 'Task update failed!');
  }
 }

 // q-read: App does not support this action.
 public function destroy($id)
 {
  return back()->with('error', 'App does not support this action.');
  $task = Task::findOrFail($id);
  $comments = $task->comments ?? collect();

  foreach ($comments as $comment)
   if ($comment->attachment && Storage::disk('public')->exists($comment->attachment))
    Storage::disk('public')->delete($comment->attachment);

  $task->delete();
  return redirect()->route('user.projects.show', $task->project_id)
   ->with('success', 'Task deleted successfully!');
 }
}