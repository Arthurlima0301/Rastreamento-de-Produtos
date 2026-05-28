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

        Schema::rename('invoices', 'supply_invoices');

        Schema::table('supply_invoices', function (Blueprint $table) {
            $table->renameColumn('invoice_code', 'supply_invoice_code');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->foreign('invoice_id')->references('id')->on('supply_invoices')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['invoice_id']);
        });

        Schema::table('supply_invoices', function (Blueprint $table) {
            $table->renameColumn('supply_invoice_code', 'invoice_code');
        });

        Schema::rename('supply_invoices', 'invoices');

        Schema::table('items', function (Blueprint $table) {
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }
};
