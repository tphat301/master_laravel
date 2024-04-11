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
    Schema::create('products', function (Blueprint $table) {
      $table->id();
      $table->integer('id_parent1')->nullable();
      $table->integer('id_parent2')->nullable();
      $table->integer('id_parent3')->nullable();
      $table->integer('id_parent4')->nullable();
      $table->integer('id_brand')->nullable();
      $table->string('slug', 255);
      $table->string('photo1', 255)->nullable();
      $table->string('photo2', 255)->nullable();
      $table->string('photo3', 255)->nullable();
      $table->string('photo4', 255)->nullable();
      $table->string('code', 255)->nullable();
      $table->string('file_attach', 255)->nullable();
      $table->string('file_youtube', 255)->nullable();
      $table->string('file_mp4', 255)->nullable();
      $table->string('status', 255)->nullable();
      $table->string('type', 255)->nullable();
      $table->string('num', 255)->nullable();
      $table->string('hash', 255)->nullable();
      $table->string('quantity', 255)->nullable();
      $table->string('title', 255);
      $table->double('sale_price')->default(0);
      $table->double('regular_price')->default(0);
      $table->double('discount')->default(0);
      $table->mediumText('options')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('products');
  }
};
