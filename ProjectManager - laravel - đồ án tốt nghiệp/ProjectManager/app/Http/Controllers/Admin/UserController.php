<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Imports\UsersImport;
use App\Exports\UsersExport_failedImportData;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersSampleExport;
use App\Exports\UsersExport;

class UserController extends Controller // q-read: doing
{
 public function index()
 {
  $search_by_account_email = request('search_by_account_email') ?? '';
  $accounts = User::where('email', 'like', '%' . $search_by_account_email . '%')->paginate(3);

  return view('pages.admin.users.index', compact('accounts'));
 }
 public function create()
 {
  $roles = Role::orderBy('name', 'ASC')->get();
  return view('pages.admin.users.create', compact('roles'));
 }
 public function store(Request $request)
 {
  $request->validate([
   'name' => 'required|string|max:255',
   'email' => 'required|email|unique:users,email',
   'roles' => 'required|array',
  ]);

  $user = User::create([
   'name' => $request->name,
   'email' => $request->email,
   'password' => bcrypt(env('PASSWORD_DEFAULT')),
   'avatar' => copy_public_storage_file('default_images/default-avatar.jpg', "avatars/default-avatar" . "_" . date('Y-m-d_H-i-s') . ".jpg"),
  ]);

  foreach ($request->roles as $role_id) {
   if (!UserRole::where('user_id', $user->id)->where('role_id', $role_id)->exists()) {
    UserRole::create(['user_id' => $user->id, 'role_id' => $role_id]);
   }
  }
  return redirect()->route('admin.users.show', $user->id)->with('success', 'Account created successfully!');
 }
 public function show($id)
 {
  $user = User::findOrFail($id);
  return view('pages.admin.users.show', compact('user'));
 }
 public function edit(User $user)
 {
  // Được quyền sửa account khi: (có quyền sửa) và (tài khoản đăng nhập phải là - (tài khoản của mình) hoặc (tài khoản super admin))
  if (Auth::id() == $user->id || Auth::id() == 1) {
   $roles = Role::orderBy('name', 'ASC')->get();
   $roles_assigned = $user->getRoles->pluck('name', 'id')->toArray();
   return view('pages.admin.users.edit', compact('user', 'roles', 'roles_assigned'));
  } else {
   return redirect()->route('admin.users.show', $user->id)->with('error', 'You do not have permission to edit this account!');
  }
 }
 public function update(Request $request, User $user)
 {
  $request->validate([
   'name' => 'required|string|max:255',
   'email' => 'required|email|unique:users,email,' . $user->id,
   'password' => 'nullable|string|min:4|confirmed',
   'roles' => 'required|array',
   'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
  ]);

  // $roles_assigned = $user->getRoles->pluck('name', 'id')->toArray();
  // if (
  //  is_User_in_any_Project($user->id)
  //  &&
  //  array_count_values($roles_assigned)
  //  !=
  //  array_count_values($request->roles)
  //  //array_count_values() sẽ kiểm tra xem hai mảng có giống nhau về các phần tử và số lần xuất hiện của mỗi phần tử.
  // )
  //  return back()->with(['error' => 'You must reassign user in your project before changing it\'s role.']);

  if ($request->hasFile('avatar')) {// Kiểm tra nếu người dùng có tải ảnh mới
   if ($user->avatar && Storage::exists('public/' . $user->avatar)) {// Xóa ảnh cũ nếu có
    Storage::delete('public/' . $user->avatar);
   }

   // Lưu ảnh mới
   $path = $request->file('avatar')->store('avatars', 'public');
   $user->avatar = $path;
  }

  $user->update([
   'name' => $request->name,
   'email' => $request->email,
   'password' => $request->filled('password') ? bcrypt($request->password) : $user->password,
   'avatar' => $request->hasFile('avatar') ? $path : $user->avatar
  ]);

  // Update user - role
  UserRole::where('user_id', $user->id)->delete();
  // Nếu người dùng là super admin, thêm role super admin (nhưng đã có hidden input role_id = 1)
  // ($user->id == 1) ? UserRole::create(['user_id' => $user->id, 'role_id' => 1]) : '';

  foreach ($request->roles as $role_id)
   UserRole::create(['user_id' => $user->id, 'role_id' => $role_id]);

  // return back()->with('success', 'Account updated successfully!');
  return redirect()->route('admin.users.show', $user->id)->with('success', 'Account updated successfully!')->with('debug', session()->all());
 }
 public function destroy($id)
 {
  return back()->with('error', 'App does not support this action.');
  if (is_User_in_any_Project($id))
   return redirect()->route('admin.users.index')->with(['error' => 'You must reassign user in your project before deleting this account.']);

  User::destroy($id);
  return redirect()->route('admin.users.index')->with('success', 'Account deleted successfully!');
 }

 // q-read: User Export
 public function importUsers(Request $request)
 {
  $request->validate([
   'account_import_file' => 'required|mimes:xlsx,csv'
  ]);

  $import = new UsersImport();
  Excel::import($import, $request->file('account_import_file'));

  if (!empty(UsersImport::$failedRows)) {
   $errorFile = 'failed_users_import.xlsx';
   Excel::store(new UsersExport_failedImportData(UsersImport::$failedRows), "public/" . $errorFile);

   return response()->json([
    'error' => 'Has some errors. Please check the file!',
    'error_file' => asset("storage/{$errorFile}") // Link tải file
   ]);
  }
  return response()->json(['success' => 'File imported successfully!']);
 }

 public function usersSampleExport()
 {
  return Excel::download(new UsersSampleExport, 'account-import-sample-file.xlsx');
 }

 public function usersExport()
 {
  return Excel::download(new UsersExport, 'accounts_data_excel_export.xlsx');
 }
}
