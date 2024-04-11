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
    Schema::create('seo', function (Blueprint $table) {
      $table->id();
      $table->integer('id_parent')->nullable();
      $table->string('type', 255)->nullable();
      $table->string('hash_seo', 255)->nullable();
      $table->mediumText('title_seo')->nullable();
      $table->mediumText('keywords')->nullable();
      $table->mediumText('description_seo')->nullable();
      $table->mediumText('schema')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('seo');
  }
};
