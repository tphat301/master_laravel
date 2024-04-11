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
    Schema::create('district', function (Blueprint $table) {
      $table->id('id_district');
      $table->string('code_district', 255)->nullable();
      $table->string('name_district', 255)->nullable();
      $table->string('type_district', 255)->nullable();
      $table->string('code_city', 255)->nullable();
      $table->string('num', 255)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('district');
  }
};
