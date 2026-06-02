<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->integer('item_number');
            $table->integer('shipment_code')->index();
            $table->integer('roll');
            $table->integer('width');
            $table->integer('length');
            $table->integer('sheets');
            $table->decimal('grammage', 6, 2);
            $table->integer('expedition_code')->unique();
            $table->string('paper', 100);
            $table->string('return_batch');
            $table->integer('packages');
            $table->decimal('package_net_weight', 8, 2);
            $table->decimal('package_gross_weight', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
