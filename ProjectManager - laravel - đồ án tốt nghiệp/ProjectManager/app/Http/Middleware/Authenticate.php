<?php

namespace App\Http\Middleware;

use App\Models\UserRole;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Http\Controllers\Home\AdminController;

class Authenticate extends Middleware
{
 /**
  * Get the path the user should be redirected to when they are not authenticated.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return string|null
  */

 public function handle($request, Closure $next, ...$guards)
 {
  $route = $request->route()->getName(); // q-read: lấy route người dùng đang cố gắng truy cập

  // q-read: Tạo role cho Super Admin nếu chưa tạo
  if (User::where('id', '1')->first()->getRoles->where('name', 'Super Admin')->first()?->name != 'Super Admin') {
   // UserRole::where('role_id', 1)->where('user_id', 1)->delete(); // BUG: Xóa role cho Super Admin
   AdminController::createUserRole(1, 1);
   return redirect()->route($route)->with('success', 'Assign again Super Admin role for Super Admin account successfully!')->withInput();
  }

  // q-read: Nếu chưa đăng nhập, lưu URL mà người dùng đang cố gắng truy cập vào session
  if (!Auth::check()) {
   session(['url.intended' => url()->current()]);
   return redirect()->route('login');
  }

  // q-read: Sau khi người dùng đăng nhập, kiểm tra nếu có URL trong session
  if (session()->has('url.intended')) {
   $redirectUrl = session()->get('url.intended');
   session()->forget('url.intended'); // Xóa URL đã lưu 
   return redirect()->to($redirectUrl)->with('success', 'Login successfully!'); // Quay lại URL mà người dùng đang cố gắng truy cập
  }

  if (Auth::user()->cant($route)) // q-read: check permission
   return redirect()->route('user.error', ['code' => '403']);
  return $next($request);
 }
}
