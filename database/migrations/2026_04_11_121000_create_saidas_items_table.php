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
        Schema::create('saidas_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('saida_id');
            $table->unsignedBigInteger('item_id');
            $table->integer('quantidade')->default(0);
            $table->timestamps();

            $table->foreign('saida_id')->references('id')->on('saidas')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saidas_items');
    }
};
