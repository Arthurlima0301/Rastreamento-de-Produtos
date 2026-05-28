<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['invoice_id']);
        });

        Schema::table('dispatch_items', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
        });

        Schema::table('items', function (Blueprint $table) {
            $table->renameColumn('invoice_id', 'supply_invoice_id');
        });

        Schema::rename('items', 'supply_items');

        Schema::table('dispatch_items', function (Blueprint $table) {
            $table->renameColumn('item_id', 'supply_item_id');
        });

        Schema::table('supply_items', function (Blueprint $table) {
            $table->foreign('supply_invoice_id')->references('id')->on('supply_invoices')->onDelete('cascade');
        });

        Schema::table('dispatch_items', function (Blueprint $table) {
            $table->foreign('supply_item_id')->references('id')->on('supply_items')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('dispatch_items', function (Blueprint $table) {
            $table->dropForeign(['supply_item_id']);
        });

        Schema::table('supply_items', function (Blueprint $table) {
            $table->dropForeign(['supply_invoice_id']);
        });

        Schema::table('dispatch_items', function (Blueprint $table) {
            $table->renameColumn('supply_item_id', 'item_id');
        });

        Schema::rename('supply_items', 'items');

        Schema::table('items', function (Blueprint $table) {
            $table->renameColumn('supply_invoice_id', 'invoice_id');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->foreign('invoice_id')->references('id')->on('supply_invoices')->onDelete('cascade');
        });

        Schema::table('dispatch_items', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }
};
