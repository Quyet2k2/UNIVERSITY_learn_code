<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
 /**
  * Run the migrations.
  *
  * @return void
  */
 public function up()
 {
  Schema::create('tasks', function (Blueprint $table) {
   $table->id();
   $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
   $table->string('name', 255);
   $table->text('description')->nullable();
   $table->enum('status', ['Open', 'Processing', 'Testing', 'PM', 'Completed'])->default('Open');
   $table->foreignId('assigned_to')->constrained('users')->onDelete('cascade');
   $table->datetime('start_time');
   $table->datetime('end_time');

   // Thêm các trường mới
   $table->decimal('bill', 10, 2); // Bill dạng tiền
   $table->datetime('first_completed_at')->nullable(); // Thời gian hoàn thành lần đầu

   $table->timestamps();
  });
 }

 /**
  * Reverse the migrations.
  *
  * @return void
  */
 public function down()
 {
  Schema::dropIfExists('tasks');
 }
};
