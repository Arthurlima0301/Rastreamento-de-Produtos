<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pallets', function (Blueprint $table) {
            $table->id();

            $table->integer('label');
            $table->decimal('package_net_weight', 10, 2)->default(0);

            $table->foreignId('load_id')
                ->constrained('loads')
                ->cascadeOnDelete();

            $table->foreignId('item_material_id')
                ->constrained('item_material')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pallet');
    }
};
