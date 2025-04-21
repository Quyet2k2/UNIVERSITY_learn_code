<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
 /**
  * Thực thi migration.
  *
  * @return void
  */
 public function up()
 {
  Schema::create('comments', function (Blueprint $table) {
   $table->id();
   $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
   $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
   $table->text('content');
   // $table->enum('status', ['pending', 'resolved', 'in_progress'])->default('pending');
   // $table->foreignId('parent_comment_id')->nullable()->constrained('comments')->onDelete('cascade');
   // $table->enum('type', ['general', 'bug_report', 'change_request', 'feedback'])->default('general');
   // $table->boolean('is_edited')->default(false);
   // $table->timestamp('edit_timestamp')->nullable();
   $table->string('attachment')->nullable();
   // $table->enum('urgency_level', ['low', 'medium', 'high'])->default('medium');
   // $table->foreignId('resolved_by')->nullable()->constrained('users')->onDelete('set null');
   // $table->timestamp('due_date')->nullable();
   $table->timestamps();
  });
 }

 /**
  * Hoàn tác migration.
  *
  * @return void
  */
 public function down()
 {
  Schema::dropIfExists('comments');
 }
};
