<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('newsletter', function (Blueprint $table) {
      $table->id();
      $table->string('fullname', 255)->nullable();
      $table->string('file_attach', 255)->nullable();
      $table->string('email', 255)->nullable();
      $table->string('phone', 255)->nullable();
      $table->string('subject', 255)->nullable();
      $table->string('type', 255)->nullable();
      $table->string('confirm_status', 255)->nullable();
      $table->mediumText('content', 255)->nullable();
      $table->mediumText('address', 255)->nullable();
      $table->string('notes', 255)->nullable();
      $table->string('num', 255)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('newsletter');
  }
};
