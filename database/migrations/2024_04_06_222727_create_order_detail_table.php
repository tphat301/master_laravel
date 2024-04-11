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
        Schema::create('order_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('id_product')->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->string('code', 255)->nullable();
            $table->string('color', 255)->nullable();
            $table->string('size', 255)->nullable();
            $table->double('regular_price')->default(0);
            $table->double('sale_price')->default(0);
            $table->integer('quantity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_detail');
    }
};
