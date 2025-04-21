<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
 /**
  * Define the model's default state.
  *
  * @return array<string, mixed>
  */
 public function definition()
 {
  // Generate a random start time for the comment (can relate to task start)
  // $start_time = fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d\TH:i');

  return [
   'content' => ucfirst(fake()->paragraph(3, true)), // Random comment content
   'task_id' => Task::inRandomOrder()->first()->id, // Random task ID
   'user_id' => User::inRandomOrder()->first()->id, // Random user ID (who is commenting)
   'created_at' => \Carbon\Carbon::now(), // Thời gian tạo (có thể thay đổi giá trị)
   'updated_at' => \Carbon\Carbon::now(), // Thời gian cập nhật (có thể thay đổi giá trị)

   // 'status' => fake()->randomElement(['pending', 'resolved', 'in_progress']), // Random status
   // 'parent_comment_id' => null, // You can modify this if you want to create nested comments
   // 'type' => fake()->randomElement(['general', 'bug_report', 'change_request', 'feedback']), // Random type
   // 'is_edited' => fake()->boolean(), // Random true/false for edited status
   // 'edit_timestamp' => fake()->dateTimeThisYear(), // Random edit timestamp
   // 'attachment' => fake()->optional()->imageUrl(), // Optional image URL as attachment
   // 'urgency_level' => fake()->randomElement(['low', 'medium', 'high']), // Random urgency level
   // 'resolved_by' => fake()->randomElement([null, User::inRandomOrder()->first()->id]), // Random resolved_by (nullable)
   // 'due_date' => fake()->optional()->dateTimeBetween('now', '+1 year'), // Optional due date
  ];
 }
}
