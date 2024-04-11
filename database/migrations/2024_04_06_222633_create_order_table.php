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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user')->nullable();
            $table->string('code', 255)->nullable();
            $table->string('fullname', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('payments', 255)->nullable();
            $table->string('email', 100)->nullable();
            $table->integer('city')->nullable();
            $table->integer('district')->nullable();
            $table->integer('ward')->nullable();
            $table->double('total_price')->default(0);
            $table->double('ship_price')->nullable();
            $table->mediumText('requirements')->nullable();
            $table->mediumText('notes')->nullable();
            $table->integer('num')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
