<?php

namespace App\Http\Controllers\Admin;

use Route;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{

 public function index()
 {
  $data = Role::paginate(15);
  return view('pages.admin.roles.index', compact('data'));
 }

 public function create()
 {
  // q-read: Not allow
  // return back()->with('error', 'App do not have this action!');
  $routes = [];
  $allRoutes = Route::getRoutes();

  foreach ($allRoutes as $route) {
   $routeName = $route->getName();
   $posAdmin = strpos($routeName, 'admin.');
   $posUser = strpos($routeName, 'user.');
   if ($posAdmin !== false || $posUser !== false && !in_array($routeName, $routes))
    array_push($routes, $routeName);
  }
  return view('pages.admin.roles.create', compact('routes'));
 }

 public function store(Request $request)
 {
  // q-read: Not allow
  // return back()->with('error', 'App do not have this action!');
  $request->validate(['name' => 'required', 'routes' => 'required|array']);

  $request->routes ? "" : $request->routes = [];
  $request->name = ucwords($request->name);
  $routes = json_encode($request->routes);
  Role::create(['name' => $request->name, 'permissions' => $routes]);
  return redirect()->route('admin.roles.index')->with('success', 'role created successfully!');
 }

 public function show(Role $role)
 {
  // q-read: Not allow
  // return back()->with('error', 'App do not have this action!');
  $model = Role::findOrFail($role->id);
  $permissions = json_decode($model->permissions);
  $routes = [];

  return view('pages.admin.roles.show', compact('routes', 'model', 'permissions'));
 }

 public function edit($id)
 {
  // q-read: Not allow
  // return back()->with('error', 'App do not have this action!');

  // Được sửa role khi: (có quyền update) và (không là các role mặc định)
  // if (!auth()->user()->hasPermission('admin.roles.update') || ($id == 1 || $id == 2 || $id == 3 || $id == 4))
  //  return redirect()->route('admin.roles.index')->with('error', 'You do not have permission to edit or update this role!');

  $model = Role::findOrFail($id);
  $permissions = json_decode($model->permissions);
  $allRoutes = Route::getRoutes();
  $routes = [];

  foreach ($allRoutes as $route) {
   $routeName = $route->getName();
   $posAdmin = strpos($routeName, 'admin.');
   $posUser = strpos($routeName, 'user.');
   if ($posAdmin !== false || $posUser !== false && !in_array($routeName, $routes))
    array_push($routes, $routeName);
  }
  return view('pages.admin.roles.edit', compact('routes', 'model', 'permissions'));
 }

 public function update(Request $request, Role $role)
 {
  // q-read: Not allow
  // return back()->with('error', 'App do not have this action!');
  $request->validate(['name' => 'required', 'routes' => 'required|array']);

  $permissions = $request->routes ?? [];
  $request->name = ucwords($request->name);
  $permissions = json_encode($permissions);
  $role->update(['name' => $request->name, 'permissions' => $permissions]);
  return back()->with('success', 'Update role successfully!');
 }

 public function destroy(Role $role)
 {
  // q-read: Not allow
  return redirect()->route("admin.roles.index")->with('error', 'App do not have this action!');

  if ($role->delete())
   return redirect()->route("admin.roles.index")->with('success', 'Delete role successfully!');
  else
   return redirect()->route("admin.roles.index")->with('error', 'Delete role failed!');
 }
}
