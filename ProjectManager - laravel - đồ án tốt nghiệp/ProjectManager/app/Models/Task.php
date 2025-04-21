<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
 use HasFactory;

 protected $fillable = ['project_id', 'name', 'description', 'status', 'assigned_to', 'start_time', 'end_time', 'bill', 'first_completed_at'];

 public function comments()
 {
  return $this->hasMany(Comment::class);
 }

 public function assignedUser()
 {
  return $this->belongsTo(User::class, 'assigned_to');
 }

}
