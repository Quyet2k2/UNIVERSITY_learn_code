<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
 use HasApiTokens, HasFactory, Notifiable;

 public function getAvatarUrlAttribute()
 {
  if ($this->avatar)
   return asset('storage/' . $this->avatar);
  else
   return asset('storage/default_images/default-avatar.jpg');
 }

 public function projects()
 {
  return $this->belongsToMany(Project::class, 'user_projects');
 }

 // q-read: custom permission
 public function getRoles()
 {
  return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
 }
 // q-read: Các route được phân quyen cho người dùng này
 public function routes()
 {
  $data = [];
  foreach ($this->getRoles as $role) {
   $permissions = json_decode($role->permissions);
   foreach ($permissions as $permission) {
    if (!in_array($permission, $data))
     array_push($data, $permission);
   }
  }
  return $data;
 }
 public function hasPermission($route)
 {
  $routes = $this->routes();
  return in_array($route, $routes) ? true : false;
 }

 // q-read: ======================================================================================================
 /**
  * The attributes that are mass assignable.
  *
  * @var array<int, string>
  */
 protected $fillable = [
  'name',
  'email',
  'password',
  'avatar',
 ];

 /**
  * The attributes that should be hidden for serialization.
  *
  * @var array<int, string>
  */
 protected $hidden = [
  'password',
  'remember_token',
 ];

 /**
  * The attributes that should be cast.
  *
  * @var array<string, string>
  */
 protected $casts = [
  'email_verified_at' => 'datetime',
 ];
}
