<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UserRole;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
 /**
  * Define the model's default state.
  *
  * @return array<string, mixed>
  */
 public function definition()
 {
  // Generate start time first
  $start_time = fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d\TH:i');

  // Generate end time after start time
  $end_time = fake()->dateTimeBetween($start_time, '+1 week')->format('Y-m-d\TH:i');

  return [
   'name' => ucfirst(fake()->words(rand(3, 5), true)), // Random Project Name
   'description' => fake()->paragraph(3, true), // Random Project Description
   'start_time' => $start_time, // Start Date
   'end_time' => $end_time, // End Date should be after start time
   'status' => 'Open', // Random Status
   // PM ngẫu nhiên, ngoại trừ tài khoản Super Admin
   'project_manager_assigned_to' => UserRole::where('role_id', 2)->whereNotIn('user_id', [1])->inRandomOrder()->first()->user_id, // Random User ID (Project Manager),

   'created_at' => \Carbon\Carbon::now(), // Thời gian tạo (có thể thay đổi giá trị)
   'updated_at' => \Carbon\Carbon::now(), // Thời gian cập nhật (có thể thay đổi giá trị)
  ];
 }
}
