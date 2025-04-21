<?php

namespace App\Http\Controllers\Home;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\PasswordReset;
use Route;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Storage;
use App\Models\Task;

class AdminController extends Controller // q-read: fixed
{
 public function dashboard()
 {
  $user = Auth::user();
  $employees = User::select('id', 'name')->get(); // Danh sách nhân viên
  $selectedUser = request('user_id', $user->id);

  // Lấy dữ liệu tasks cho nhân viên đã chọn
  $tasks = Task::where('assigned_to', $selectedUser);

  // Tổng KPI và số tasks
  $totalKpi = $tasks->sum('bill');
  $totalTasks = $tasks->count();

  // Tính điểm hiệu suất
  $lastMonth = now()->subMonth()->format('Y-m'); // Lấy tháng trước dạng YYYY-MM
  $totalKpiLastMonth = $tasks->whereRaw("DATE_FORMAT(tasks.first_completed_at, '%Y-%m') = ?", [$lastMonth])->sum('bill');
  $totalTasksLastMonth = $tasks->count();

  // Xếp hạng hiệu suất
  $performanceScores = ['A+' => 90, 'A' => 80, 'B+' => 70];
  $performanceScore = 'B+';
  foreach ($performanceScores as $score => $threshold) {
   if ($totalKpiLastMonth >= $threshold) {
    $performanceScore = $score;
    break;
   }
  }

  $kpiData = [
   'total_kpi' => round($totalKpiLastMonth, 2),
   'total_tasks' => $totalTasksLastMonth,
   'performance_score' => $performanceScore,
  ];

  // 📌 XẾP HẠNG TỔNG THỂ (có phân trang)
  $rankings = Task::join('users', 'tasks.assigned_to', '=', 'users.id')
   ->select('users.id', 'users.name', DB::raw('SUM(tasks.bill) as total_kpi'))
   ->groupBy('users.id', 'users.name')
   ->orderBy('total_kpi', 'desc')
   ->paginate(5, ['*'], 'all_time_page');

  // 📌 Gán rank chính xác cho từng nhân viên
  $startRank = ($rankings->currentPage() - 1) * $rankings->perPage() + 1;
  foreach ($rankings as $index => $employee) {
   $employee->rank = $startRank + $index;
  }

  // 📌 XẾP HẠNG THEO THÁNG HIỆN TẠI (có phân trang)
  $currentMonth = now()->format('Y-m');
  $monthlyRankings = Task::join('users', 'tasks.assigned_to', '=', 'users.id')
   ->whereRaw("DATE_FORMAT(tasks.first_completed_at, '%Y-%m') = ?", [$currentMonth])
   ->select('users.id', 'users.name', DB::raw('SUM(tasks.bill) as total_kpi'))
   ->groupBy('users.id', 'users.name')
   ->orderBy('total_kpi', 'desc')
   ->paginate(5, ['*'], 'monthly_page');

  $startRankMonthly = ($monthlyRankings->currentPage() - 1) * $monthlyRankings->perPage() + 1;
  foreach ($monthlyRankings as $index => $employee) {
   $employee->rank = $startRankMonthly + $index;
  }

  // 📌 Tìm rank của nhân viên đã chọn
  $userRank = Task::join('users', 'tasks.assigned_to', '=', 'users.id')
   ->select('users.id', 'users.name', DB::raw('SUM(tasks.bill) as total_kpi'))
   ->groupBy('users.id', 'users.name')
   ->orderBy('total_kpi', 'desc')->get()
   ->pluck('id')->search($selectedUser);
  $userMonthlyRank = Task::join('users', 'tasks.assigned_to', '=', 'users.id')
   ->whereRaw("DATE_FORMAT(tasks.first_completed_at, '%Y-%m') = ?", [$currentMonth])
   ->select('users.id', 'users.name', DB::raw('SUM(tasks.bill) as total_kpi'))
   ->groupBy('users.id', 'users.name')
   ->orderBy('total_kpi', 'desc')->get()
   ->pluck('id')->search($selectedUser);

  // Câu nói động lực
  $quotes = config('__quotes');

  return view('pages.home.dashboard', [
   'user' => $user,
   'employees' => $employees,
   'selectedUser' => $selectedUser,
   'kpiData' => $kpiData,
   'rankings' => $rankings,
   'monthlyRankings' => $monthlyRankings,
   'userRank' => $userRank !== false ? $userRank + 1 : "##",
   'userMonthlyRank' => $userMonthlyRank !== false ? $userMonthlyRank + 1 : "##",
   'quoteOfTheDay' => $quotes[array_rand($quotes)]
  ]);
 }

 public function login()
 {
  return view('pages.home.login');
 }
 public function postLogin(Request $req)
 {
  $req->validate([
   'email' => 'required|email',
   'password' => 'required|min:4',
  ]);

  if (Auth::attempt($req->only('email', 'password')))
   return redirect()->route('user.dashboard')->with('success', 'Login successfully!');
  return redirect()->back()->with('error', 'Email or password is incorrect!')->withInput();
 }
 public function logout()
 {
  Auth::logout();
  return redirect()->route('login')->with('success', 'Logout successfully!');
 }

 // q-read: fresh - hãy fresh csdl hệ thống trước hết
 public function createSuperAdminAccount()
 {
  User::create([
   'name' => 'Super Admin',
   'email' => 'quyet05122002@gmail.com',
   'password' => bcrypt(env('PASSWORD_DEFAULT')),
   // q-read: gán ngay từ đầu
   // 'avatar' => copy_public_storage_file('default_images/Super_Admin.jpg', "avatars/Super_Admin" . date('Y-m-d_H-i-s') . ".jpg"),
  ]);
  // q-read: Vứt ở đâu đó, để khi tạo xong thì nó cập nhật lại
  // User::where('id', '1')->first()->update(['avatar' => copy_public_storage_file('default_images/Super_Admin.jpg', "avatars/Super_Admin" . "_" . date('Y-m-d_H-i-s') . ".jpg")]);
 }
 public static function createRole($routesArray, $roleName)
 {
  if (!Role::where('name', $roleName)->exists()) {
   $permissions = json_encode($routesArray);
   Role::create(['name' => $roleName, 'permissions' => $permissions]);
  }
 }
 public static function createUserRole($user_id, $role_id)
 {
  if (!UserRole::where('user_id', $user_id)->where('role_id', $role_id)->exists()) {
   UserRole::create(['user_id' => $user_id, 'role_id' => $role_id]);
  }
 }
 public function fresh()
 {
  try {
   if (!User::where('id', '1')->exists()) {
    $allRoutes = Route::getRoutes();
    $routesArray = [];
    foreach ($allRoutes as $route)
     array_push($routesArray, $route->getName());

    $this->createSuperAdminAccount();
    $this->createRole($routesArray, 'Super Admin'); // role_id = 1
    $this->createUserRole(1, 1);

    $this->createRole(config('_permission_1_projectManager'), 'Project Manager'); // role_id = 2
    $this->createRole(config('_permission_2_dev'), 'Developer'); // role_id = 3
    $this->createRole(config('_permission_3_tester'), 'Tester'); // role_id = 4

    // q-read: chạy thử nghiệm - Testing - gán tất cả role cho super admin - BUG
    // $this->createUserRole(1, 2);
    // $this->createUserRole(1, 3);
    // $this->createUserRole(1, 4);

    // q-read: xóa hết các file đã lưu trên hệ thống
    Storage::disk('public')->deleteDirectory('attachments');
    Storage::disk('public')->deleteDirectory('avatars');

    return redirect()->route('login')->with('success', 'Fresh successfully!')->withInput();
   } else
    return redirect()->route('login')->with('error', 'Fresh failed!');
  } catch (\Throwable $th) {
   \Log::error($th);
   return back()->with('error', 'Something went wrong!');
  }
 }

 // q-read: Public routes
 public function laravel()
 {
  return view('pages.home.laravel');
 }
 public function error(Request $request)
 {
  $code = $request->code;
  $error = config('_custom_error.' . $code);

  $routes = Route::getRoutes();
  return view('pages.home.error', $error)->with('routes', $routes);
 }
 // q-read: Hiển thị form yêu cầu reset mật khẩu (bước 1)
 public function forgetPasswordView()
 {
  return view('pages.home.forget_password');
 }
 // Xử lý gửi email với link reset mật khẩu (bước 2)
 public function forgetPasswordEmail(Request $request)
 {
  $request->validate([
   'email' => 'required|email'
  ]);

  $response = Password::sendResetLink($request->only('email'));
  return $response == Password::RESET_LINK_SENT
   ? back()->with('success', trans($response))
   : back()->with('error', trans($response));
 }
 // Hiển thị form để người dùng nhập mật khẩu mới (bước 3)
 public function showResetPasswordForm($token, Request $request)
 {
  $email = $request->email ?? null;

  // Kiểm tra token
  $resetRecord = DB::table('password_resets')->where('email', $email)->first();

  if ($resetRecord && Hash::check($token, $resetRecord->token)) {
   // Token hợp lệ
   return view('pages.home.reset_password', compact('token', 'email'));
  } else {
   // Token không hợp lệ hoặc hết hạn
   return redirect()->route('password.request')->with([
    'email' => 'Request password reset is expired!'
   ]);
  }
 }
 // Xử lý việc reset mật khẩu mới (bước 4)
 public function resetPasswordPost(Request $request)
 {
  $request->validate([
   'email' => 'required|email',
   'password' => 'required|confirmed|min:4',
   'token' => 'required'
  ]);

  $response = Password::reset(
   $request->only('email', 'password', 'password_confirmation', 'token'),
   function ($user) use ($request) {
    $user->forceFill([
     'password' => Hash::make($request->password),
    ])->save();

    event(new PasswordReset($user));
   }
  );

  return $response == Password::PASSWORD_RESET
   ? redirect()->route('login')->with('status', trans($response))
   : back()->with(['email' => trans($response)]);
 }
}
