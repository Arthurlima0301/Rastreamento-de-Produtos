<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_material', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->foreignId('material_id')->constrained('materials');
            $table->foreignId('material_invoice_id')->constrained('material_invoice')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_material');
    }
};
