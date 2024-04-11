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
    Schema::create('seopage', function (Blueprint $table) {
      $table->id();
      $table->string('title', 255)->nullable();
      $table->string('type', 255)->nullable();
      $table->string('photo', 255)->nullable();
      $table->mediumText('keywords', 255)->nullable();
      $table->mediumText('description', 255)->nullable();
      $table->string('hash', 255)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('seopage');
  }
};
