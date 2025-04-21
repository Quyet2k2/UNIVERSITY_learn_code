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
    Schema::create('user_projects', function (Blueprint $table) {
      $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
      $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');

      $table->primary(['user_id', 'project_id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('user_projects');
  }
};
