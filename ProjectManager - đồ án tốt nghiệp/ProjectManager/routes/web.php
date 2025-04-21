<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Home\AdminController;
use App\Http\Controllers\User\ProjectController;
use App\Http\Controllers\User\TaskController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\ReportController;

/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Phân loại route của user và admin trên code, còn ở ngoài vẫn là chung - tùy theo yêu cầu.
// ================= q-read: Admin Route
Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'as' => 'admin.'], function () {
 Route::resources([
  'users' => UserController::class,
  'roles' => RoleController::class,
 ]);

 // TEST: Excel Import & Export
 Route::get('/export-users', [UserController::class, 'usersExport'])->name('users.export');
 Route::get('/account-import-file', [UserController::class, 'usersSampleExport'])->name('users.sample_import');
 Route::post('/import-users', [UserController::class, 'importUsers'])->name('users.import');
});
// ================= q-read: User Route
Route::group(['prefix' => 'user', 'middleware' => 'auth', 'as' => 'user.'], function () {
 Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
 Route::get('/error', [AdminController::class, 'error'])->name('error');
 Route::resources([
  'projects' => ProjectController::class,
  'tasks' => TaskController::class,
  'comments' => CommentController::class,
 ]);
 Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
 Route::get('/reports/user/{id}', [ReportController::class, 'userReport'])->name('reports.user');

});

// ================= q-read: Public Routes ========================================================================
Route::get('/fresh-app', [AdminController::class, 'fresh']);
Route::get('/laravel', [AdminController::class, 'laravel'])->name('laravel');
Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/postLogin', [AdminController::class, 'postLogin'])->name('postLogin');
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

Route::get('/forgetPasswordView', [AdminController::class, 'forgetPasswordView'])->name('password.request');
Route::post('/forgetPasswordEmail', [AdminController::class, 'forgetPasswordEmail'])->name('password.email');
Route::get('/showResetPasswordForm/{token}', [AdminController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/resetPasswordPost', [AdminController::class, 'resetPasswordPost'])->name('password.update');
