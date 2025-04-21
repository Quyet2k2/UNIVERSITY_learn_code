<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\UserProject;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
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

  $project_id = Project::inRandomOrder()->first()->id;
  $assigned_to = UserProject::where('project_id', $project_id)->inRandomOrder()->first()?->user_id; // Random User ID (Assigned)
  return [
   'name' => ucfirst(fake()->words(rand(3, 6), true)), // Random Task Name
   'description' => ucfirst(fake()->paragraph()), // Random Task Description
   'status' => fake()->randomElement(['Processing', 'Testing', 'Completed']), // Random Status
   // 'Open', 'Processing', 'Testing', 'PM', 'Completed'
   'start_time' => $start_time,
   'end_time' => $end_time,
   'project_id' => $project_id,
   'assigned_to' => $assigned_to,

   'bill' => fake()->randomFloat(2, 0, 10),
   'first_completed_at' => fake()->dateTimeBetween($start_time, $end_time),

   'created_at' => \Carbon\Carbon::now(), // Thời gian tạo (có thể thay đổi giá trị)
   'updated_at' => \Carbon\Carbon::now(), // Thời gian cập nhật (có thể thay đổi giá trị)
  ];
 }
}
