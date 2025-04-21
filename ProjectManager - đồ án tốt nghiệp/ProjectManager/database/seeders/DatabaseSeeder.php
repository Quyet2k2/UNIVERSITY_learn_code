<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Http\Controllers\Home\AdminController;
use Illuminate\Database\Seeder;
// 
use App\Models\User;
use App\Models\UserRole;
// 
use App\Models\Project;
use App\Models\UserProject;
// 
use App\Models\Task;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
 /**
  * Seed the application's database.
  *
  * @return void
  */
 public function run()
 {
  // \App\Models\User::factory(10)->create();

  // \App\Models\User::factory()->create([
  //     'name' => 'Test User',
  //     'email' => 'test@example.com',
  // ]);
  // 
  // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // //  q-read
  $a = new AdminController();
  $a->fresh();
  User::where('id', '1')->first()->update(['avatar' => copy_public_storage_file('default_images/Super_Admin.jpg', "avatars/Super_Admin" . "_" . date('Y-m-d_H-i-s') . ".jpg")]);
  $now = date('Y-m-d_H-i-s');
  // q-read: Tạo Người dùng - chạy thử nghiệm 
  $PM_1 = User::factory()->create(['name' => 'Phạm Văn Quyết - PM 1', 'email' => 'quyetngoai@gmail.com', 'avatar' => copy_public_storage_file('default_images/Project_Manager.jpg', "avatars/Project_Manager_$now.jpg")]);
  UserRole::create(['user_id' => $PM_1->id, 'role_id' => 2,]);
  $PM_2 = User::factory()->create(['name' => 'Phạm Văn Quyết - PM 2', 'email' => 'quyetxautrai2k2@gmail.com', 'avatar' => copy_public_storage_file('default_images/Dev_1.jpg', "avatars/Dev_1_$now.jpg")]);
  UserRole::create(['user_id' => $PM_2->id, 'role_id' => 2,]);
  $Dev = User::factory()->create(['name' => 'Phạm Văn Quyết - dev', 'email' => 'quyetxautrainhat@gmail.com', 'avatar' => copy_public_storage_file('default_images/Dev_2.jpg', "avatars/Dev_2_$now.jpg")]);
  UserRole::create(['user_id' => $Dev->id, 'role_id' => 3,]);
  $Tester = User::factory()->create(['name' => 'Phạm Văn Quyết - tester', 'email' => 'phamngochoa0512@gmail.com', 'avatar' => copy_public_storage_file('default_images/Tester.jpg', "avatars/Tester_$now.jpg")]);
  UserRole::create(['user_id' => $Tester->id, 'role_id' => 4,]);

  // // Tạo role admin cho PM - BUG
  // UserRole::create(['user_id' => $PM_1->id, 'role_id' => 1,]);

  // +++++++++++++++++++++++++++ DATA TEST +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // $project_count = 7;
  // $task_count = 6;
  // $comment_count = 6;

  $project_count = 20;
  $task_count = 30;
  $comment_count = 3;
  for ($i = 1; $i <= $project_count; $i++) {
   $project = Project::factory()->create();

   //  // // BUG - TEST: tạo số lượng user thêm = số lượng dự án
   //  // $dev = User::factory()->create();
   //  // UserRole::create(['user_id' => $dev->id, 'role_id' => 3,]);
   //  // END TEST +++++++++++++++++++++++++++++++++++++++++++++++++

   foreach (User::where('id', '!=', 1)->get() as $user) // UserProject Creation Loop for all users to each project
    UserProject::create(['user_id' => $user->id, 'project_id' => $project->id]);

   // Task Creation Loop for each project
   for ($j = 1; $j <= $task_count; $j++) {
    $task = Task::factory()->create(['project_id' => $project->id]);

    // Comment Creation Loop for each task
    for ($k = 1; $k <= $comment_count; $k++)
     Comment::factory()->create(['task_id' => $task->id]);
   }
  }
 }
}

// q-read: 
// php artisan db:seed