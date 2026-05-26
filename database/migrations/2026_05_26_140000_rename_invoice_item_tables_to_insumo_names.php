<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('invoices', 'supply_invoices');
        Schema::rename('items', 'supply_items');

        Schema::table('supply_invoices', function (Blueprint $table) {
            $table->renameColumn('invoice_code', 'supply_invoice_code');
        });

        Schema::table('supply_items', function (Blueprint $table) {
            $table->renameColumn('invoice_id', 'supply_invoice_id');
        });

        Schema::table('dispatch_items', function (Blueprint $table) {
            $table->renameColumn('item_id', 'supply_item_id');
        });
    }

    public function down(): void
    {
        Schema::table('dispatch_items', function (Blueprint $table) {
            $table->renameColumn('supply_item_id', 'item_id');
        });

        Schema::table('supply_items', function (Blueprint $table) {
            $table->renameColumn('supply_invoice_id', 'invoice_id');
        });

        Schema::table('supply_invoices', function (Blueprint $table) {
            $table->renameColumn('supply_invoice_code', 'invoice_code');
        });

        Schema::rename('supply_items', 'items');
        Schema::rename('supply_invoices', 'invoices');
    }
};
