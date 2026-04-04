<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->unsignedBigInteger('nota_fiscal_id');
            $table->unsignedBigInteger('insumo_id');
            $table->integer('quantidade');
            $table->timestamps();

            $table->foreign('nota_fiscal_id')->references('id')->on('nota_fiscal')->onDelete('cascade');
            $table->foreign('insumo_id')->references('id')->on('insumos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
