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
        Schema::table('items', function (Blueprint $table) {
            $table->decimal('quantity', 15, 2)->change();
        });

        Schema::table('dispatch_items', function(Blueprint $table){
            $table->decimal('quantity',15,2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->integer('quantity')->change();
        });

        Schema::table('dispatch_items', function (Blueprint $table) {
            $table->integer('quantity')->change();
        });
    }
};
