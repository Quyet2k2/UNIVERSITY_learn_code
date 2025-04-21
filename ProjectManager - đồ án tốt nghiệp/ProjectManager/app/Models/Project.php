<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Project extends Model
{
 use HasFactory;
 protected $table = 'projects';
 protected $fillable = ['name', 'description', 'status', 'project_manager_assigned_to', 'start_time', 'end_time'];


 public function users()
 {
  return $this->belongsToMany(User::class, 'user_projects');
 }

 public function tasks()
 {
  return $this->hasMany(Task::class);
  // Nếu trong model Project có hasMany(Task::class), 
  // nó sẽ tự hiểu khóa ngoại trong bảng tasks là 
  // project_id (tức là tên_model_ở_số_ít + _id).
 }
}
