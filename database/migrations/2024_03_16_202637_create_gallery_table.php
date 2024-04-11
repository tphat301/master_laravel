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
    Schema::create('gallery', function (Blueprint $table) {
      $table->id();
      $table->integer('id_parent')->nullable();
      $table->string('hash', 255)->nullable();
      $table->string('photo', 255)->nullable();
      $table->string('title', 255)->nullable();
      $table->string('num', 255)->nullable();
      $table->string('type', 255)->nullable();
      $table->string('status', 255)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('gallery');
  }
};
