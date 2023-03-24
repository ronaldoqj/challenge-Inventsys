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
            $table->integer('oid')->unique()->nullable();
            $table->integer('id_sector')->nullable();
            $table->integer('latitude')->nullable();
            $table->integer('longitude')->nullable();
            $table->integer('id_manufacturer')->nullable();
            $table->integer('id_item_model')->nullable();
            $table->integer('id_voltage')->nullable();
            $table->timestamps();

            $table->foreign('id_sector')->references('id')->on('sectors');
            $table->foreign('id_manufacturer')->references('id')->on('manufacturers');
            $table->foreign('id_item_model')->references('id')->on('item_models');
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
