<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $defaultClientId = DB::table('clients')->insertGetId([
            'name' => 'Cliente padrao',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Schema::table('supplies', function (Blueprint $table) use ($defaultClientId) {
            $table->foreignId('client_id')
                ->default($defaultClientId)
                ->after('unit_of_measure')
                ->constrained('clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supplies', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
    }
};
