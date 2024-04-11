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
    Schema::create('tag_news', function (Blueprint $table) {
      $table->id('id_tag_news');
      $table->string('id_parent', 255)->nullable();
      $table->string('id_tag', 255)->nullable();
      $table->string('type_tag_news', 255)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tag_news');
  }
};
