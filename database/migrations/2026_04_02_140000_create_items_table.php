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
            $table->integer('number');
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('supply_id');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('supply_id')->references('id')->on('supplies');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
