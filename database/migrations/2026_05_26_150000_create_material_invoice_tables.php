<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('material_invoice_code')->unique();
            $table->timestamps();
        });

        Schema::create('material_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials');
            $table->foreignId('material_invoice_id')->constrained('material_invoices')->cascadeOnDelete();
            $table->decimal('roll_quantity', 12, 2);
            $table->decimal('weight', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_items');
        Schema::dropIfExists('material_invoices');
    }
};
