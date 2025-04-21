<?php
//  composer.json - helper
// "autoload": {
//     "files": [
//         "app/Helpers/helper.php"
//     ]
// }
//  ========================================================================================
use App\Models\Comment;
use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use App\Models\UserProject;
use Carbon\Carbon;

// q-read: format
if (!function_exists('get_local_date_format')) {
 function get_local_date_format($contain_date_object)
 {
  // return optional(Carbon::parse($contain_date_object))->format('d/m/Y H:i') ?? 'No date';
  return optional(Carbon::parse($contain_date_object))->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') ?? 'No date';
 }
}//  lấy thời gian theo múi giờ - để hiển thị cho kiểu timestamp tạo tự động
if (!function_exists('get_date_time_string')) {
 function get_date_time_string($timeString)
 {
  return Carbon::parse($timeString)->toDateTimeString();
 }
}//  lấy chuỗi theo định dạng datetime - theo định dạng chuẩn 'Y-m-d H:i:s'. Để hiển thị lên kiểu datetime

// q-read: tính toán
if (!function_exists('project_calc_percent')) {
 function project_calc_percent($project_id)
 {
  if (!Project::find($project_id))
   return 0;
  $totalTasks = Task::where('project_id', $project_id)->count();
  $completedTasks = Task::where('project_id', $project_id)->where('status', 'completed')->count();

  if ($totalTasks == 0)
   return 0;
  $percentCompleted = ($completedTasks / $totalTasks) * 100;
  return round($percentCompleted, 2);
 }
}//  tính tiến trình của dự án - cơ bản
if (!function_exists('task_calc_percent')) {
 function task_calc_percent($task)
 {
  switch ($task->status) {
   case 'Completed':
    return 100;
   case 'PM':
    return 60;
   case 'Testing':
    return 50;
   case 'Processing':
    return 30;
   case 'Open':
    return 0;
   default:
    return 0;
  }
 }
}//  tính tiến trình của task - suy diễn

// q-read: get data - sử dụng cho views
if (!function_exists('get_user_by_id')) {
 function get_user_by_id($user_id)
 {
  return User::find($user_id);
 }
}// Sử dụng trong Views - lấy user theo user_id
if (!function_exists('get_project_by_id')) {
 function get_project_by_id($project_id)
 {
  return Project::find($project_id);
 }
}//  lấy Project theo project_id
if (!function_exists('get_user_ids_in_project')) {
 function get_user_ids_in_project($project_id)
 {
  // Lấy danh sách user_id từ bảng UserProject
  $user_ids = UserProject::where('project_id', $project_id)
   ->pluck('user_id'); // Lấy user_id của tất cả người dùng trong dự án

  // Tìm dự án và lấy project_manager_assigned_to
  $project = Project::find($project_id); // Truy vấn dự án để lấy project_manager_assigned_to

  // Nếu dự án tồn tại và có project_manager_assigned_to, thêm vào danh sách user_ids
  if ($project && $project->project_manager_assigned_to) {
   $user_ids->push($project->project_manager_assigned_to); // Thêm project manager vào
  }

  // Loại bỏ các giá trị trùng lặp và chuyển thành mảng
  return $user_ids->unique()->toArray(); // Trả về mảng các user_id không trùng lặp
 }
}//  lấy user_id của những người dùng có trong dự án theo project_id và cả pm
if (!function_exists('get_project_ids_of_user')) {
 function get_project_ids_of_user($user_id)
 {
  // Lấy các project_id mà user này tham gia từ bảng UserProject
  $user_projects = UserProject::where('user_id', $user_id)
   ->pluck('project_id'); // Trả về mảng các project_id

  // Lấy các project_id mà user này là project manager từ bảng Project
  $pm_projects = Project::where('project_manager_assigned_to', $user_id)
   ->pluck('id'); // Trả về mảng các project_id

  // Kết hợp cả hai mảng và loại bỏ trùng lặp
  $merged_projects = $user_projects->merge($pm_projects);

  // Loại bỏ các giá trị trùng lặp và chuyển kết quả thành mảng
  return $merged_projects->unique()->toArray(); // Trả về mảng không trùng lặp
 }
} //  lấy project_id của những người dùng và cả pm có trong PROJECT theo user_id 

// q-read: set data
if (!function_exists('set_project_status_by_tasks')) {
 function set_project_status_by_tasks($project_id)
 {
  $project = Project::find($project_id);
  if (!$project || $project->status == 'Closed')
   return $project->status ?? "";

  $totalTasks = Task::where('project_id', $project_id)->count();
  $percentCompleted = project_calc_percent($project_id);

  // Nếu không có task nào trong dự án, trạng thái dự án là Open
  if ($totalTasks == 0)
   $project->status = 'Open';

  // Nếu có task trong dự án, trạng thái dự án là Processing
  if ($totalTasks > 0)
   $project->status = 'Processing';

  // Nếu tất cả task trong dự án đã hoàn thành 100%, trạng thái dự án là UAT
  if ($percentCompleted == 100)
   $project->status = 'UAT';

  $project->update();
  return $project->status;
 }
}// set status - câp nhật trạng thái dự án theo tiền trình cơ bản
// q-read: data check
if (!function_exists('checkInternetConnection')) {
 function checkInternetConnection()
 {
  $connected = @fsockopen("8.8.8.8", 53, $errno, $errstr, 2);
  if ($connected) {
   fclose($connected);
   return true;
  }
  return false;
 }
} // kiem tra ket noi internet
if (!function_exists('is_User_in_any_Project')) {
 function is_User_in_any_Project($user_id)
 {
  $query = DB::table('projects')
   ->where('status', '!=', 'Closed')
   ->where('project_manager_assigned_to', $user_id)
   ->selectRaw('id');

  $query = $query->union(
   DB::table('user_projects')
    ->join('projects', 'projects.id', '=', 'user_projects.project_id')
    ->where('projects.status', '!=', 'Closed')
    ->where('user_projects.user_id', $user_id)
    ->selectRaw('projects.id')
  );

  $query = $query->union(
   DB::table('tasks')
    ->where('status', '!=', 'Completed')
    ->where('assigned_to', $user_id)
    ->selectRaw('id')
  );

  return DB::table(DB::raw("({$query->toSql()}) as combined"))->mergeBindings($query)->exists();
 }
}// Kiểm tra xem người dùng có trong dự án - task không
if (!function_exists('copy_public_storage_file')) {
 function copy_public_storage_file($sourcePath, $destinationPath)
 {
  if (Storage::exists("public/" . $sourcePath)) {
   // \Log::info("Copying file from: $sourcePath to $destinationPath");

   $destinationDir = dirname("public/" . $destinationPath); // Đảm bảo thư mục đích tồn tại trước khi copy
   if (!Storage::exists($destinationDir))
    Storage::makeDirectory($destinationDir);

   $status = Storage::copy("public/" . $sourcePath, "public/" . $destinationPath);
   // \Log::info(
   //  $status
   //  ?
   //  "Copied file: " . public_path("storage/") . "$sourcePath \nto " . public_path("storage/") . "$destinationPath"
   //  :
   //  "Failed to copy file: " . public_path("storage/") . "$sourcePath \nto " . public_path("storage/") . "$destinationPath"
   // );
   return $destinationPath;
  }
  \Log::info("Source file not found: {$sourcePath}");


  return null;
 }
} // Sao chép file từ vị trí gốc đến vị trí mới trong storage/public - BUG: no call in AdminController (vì nó éo chạy =>>) - có thể do đó là đang "hàm static"

