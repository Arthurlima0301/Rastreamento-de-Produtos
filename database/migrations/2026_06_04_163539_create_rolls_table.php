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
        Schema::create('rolls', function (Blueprint $table) {
            $table->id();
            $table->string('label', 100);
            $table->decimal('weight', 10, 2);
            $table->enum('status', ['EM_ESTOQUE', 'CORTADA']);
            $table->foreignId('item_material_id')->constrained('item_material')->onDelete('cascade');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rolls');
    }
};
