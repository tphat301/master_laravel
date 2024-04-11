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
    Schema::create('category_products', function (Blueprint $table) {
      $table->id();
      $table->integer('id_parent')->nullable();
      $table->integer('level')->nullable();
      $table->string('title', 255)->nullable();
      $table->string('photo1', 255)->nullable();
      $table->string('photo2', 255)->nullable();
      $table->string('photo3', 255)->nullable();
      $table->string('photo4', 255)->nullable();
      $table->string('type', 255)->nullable();
      $table->string('status', 255)->nullable();
      $table->string('slug', 255)->nullable();
      $table->mediumText('desc')->nullable();
      $table->mediumText('content')->nullable();
      $table->mediumText('options')->nullable();
      $table->integer('num')->nullable();
      $table->string('hash', 255)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('category_products');
  }
};
