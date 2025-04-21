<?php

namespace App\Http\Controllers\User;

use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use App\Models\UserProject;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{

 public function index()
 {
  $query = Project::query(); // Xác định truy vấn cơ bản
  $search_by_project_name = request('search_by_project_name') ?? "";

  if (auth()->user()->id != 1) { // Không phải super admin
   // Lấy danh sách các project_id mà người dùng tham gia hoặc là project manager
   $project_ids = get_project_ids_of_user(auth()->user()->id);

   // Lọc các dự án mà người dùng là thành viên hoặc làm project manager
   $query->whereIn('id', $project_ids); // Lọc theo project_id
  }

  // Lọc dự án theo tên (nếu có)
  if ($search_by_project_name) {
   $query->where('name', 'like', '%' . $search_by_project_name . '%');
  }

  // Sắp xếp và phân trang dự án
  $projects = $query
   ->orderByRaw("FIELD(status, 'Open', 'Processing', 'UAT', 'Closed')")
   ->orderBy('end_time', 'asc')
   ->paginate(4);

  return view('pages.user.projects.index')->with('projects', $projects);
 }

 public function create()
 {
  $PM_user_ids = UserRole::where('role_id', 2)->pluck('user_id');
  $users = User::all();
  return view('pages.user.projects.create', compact('PM_user_ids', 'users'));
 }

 public function store(Request $request)
 {
  // dd($request->all());
  $validated = $request->validate([
   'name' => 'required|string|max:255',
   'project_manager_assigned_to' => 'required|exists:users,id',
   'project_assigned_to' => 'required|array', // Kiểm tra là mảng
   'project_assigned_to.*' => 'exists:users,id', // Kiểm tra từng ID người dùng có tồn tại trong bảng users
   'description' => 'nullable',
   'start_time' => 'required|date|date_format:Y-m-d\TH:i',
   'end_time' => 'required|date|date_format:Y-m-d\TH:i|after_or_equal:start_time',
  ], Lang::get('validation'));
  $validated['status'] = "Open";
  // dd($validated);
  $project = Project::create($validated);

  UserProject::where('project_id', $project->id)->delete();// xóa dữ liệu cũ
  if (is_array($request->project_assigned_to)) {
   foreach ($request->project_assigned_to as $user_id) {
    UserProject::create(['project_id' => $project->id, 'user_id' => $user_id]);
   }
  }
  $pm = User::where('id', $project->project_manager_assigned_to)->first();
  $usersOfProject = $project->users->push($pm)->unique('id'); // Thêm PM + Lọc trùng

  return redirect()->route('user.projects.show', compact('project', 'usersOfProject'))->with('success', 'Project created successfully!');
 }

 public function show($id)
 {
  $project = Project::findOrFail($id);
  $pm = User::where('id', $project->project_manager_assigned_to)->first();
  $usersOfProject = $project->users->push($pm)->unique('id'); // Thêm PM + Lọc trùng

  // q-read: Người dùng không là super admin, và không là thành viên dự án, thì không cho phép xem!
  if (auth()->user()->id != 1 && !in_array(auth()->user()->id, get_user_ids_in_project($id)))
   return redirect()->route('user.projects.index')->with('error', 'You do not have permission to view this project!');

  $tasks = Task::where('project_id', $id)
   ->orderByRaw("FIELD(status, 'Open', 'Processing', 'Testing', 'PM', 'Completed')")
   ->orderBy('end_time', 'asc')
   ->paginate(4);

  return view('pages.user.projects.show', compact('project', 'pm', 'usersOfProject', 'tasks'));
 }

 public function edit($id)
 {
  $project = Project::findOrFail($id);
  $PM_user_ids = UserRole::where('role_id', 2)->pluck('user_id');
  $users = User::all();
  $pm = User::where('id', $project->project_manager_assigned_to)->first();
  $usersOfProject = $project->users->push($pm)->unique('id'); // Thêm PM + Lọc trùng
  return view('pages.user.projects.edit', compact('project', 'PM_user_ids', 'users', 'usersOfProject'));
 }

 public function update(Request $request, $id)
 {
  $project = Project::findOrFail($id);
  $validated = $request->validate([
   'name' => 'required|string|max:255',
   'project_manager_assigned_to' => 'required|exists:users,id',
   'project_assigned_to' => 'required|array', // Kiểm tra là mảng
   'project_assigned_to.*' => 'exists:users,id', // Kiểm tra từng ID người dùng có tồn tại trong bảng users
   'description' => 'nullable',
   'status' => 'required|in:Open,Processing,UAT,Closed',
   'start_time' => 'required|date|date_format:Y-m-d\TH:i',
   'end_time' => 'required|date|date_format:Y-m-d\TH:i|after_or_equal:start_time',
  ], Lang::get('validation'));

  UserProject::where('project_id', $project->id)->delete(); // xóa dữ liệu cũ
  if (is_array($request->project_assigned_to)) {
   foreach ($request->project_assigned_to as $user_id) {
    UserProject::create(['project_id' => $project->id, 'user_id' => $user_id]);
   }
  }
  $project->update($validated);
  return redirect()->route('user.projects.show', $project->id)->with('success', 'Project updated successfully!');
 }

 // q-read: App does not support this action.
 public function destroy($id)
 {
  return back()->with('error', 'App does not support this action.');
  $project = Project::findOrFail($id);
  $tasks = $project->tasks ?? collect();

  foreach ($tasks as $task) {
   $comments = $task->comments ?? collect();

   foreach ($comments as $comment)
    if ($comment->attachment && Storage::exists('public/' . $comment->attachment))
     Storage::delete('public/' . $comment->attachment);

   $task->delete();
  }

  $project->delete();
  return redirect()->route('user.projects.index')->with('success', 'Project deleted successfully!');
 }
}
