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
        Schema::create('loads', function (Blueprint $table) {
            $table->id();
            $table->date('cutted_at');
            $table->enum('turn', ['DIURNO', 'VESPERTINO', 'NOTURNO']);
            $table->text('observation')->nullable();
            $table->foreignId('machine_id')->constrained('machines')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::table('rolls', function (Blueprint $table) {
            $table->foreignId('load_id')->nullable()->constrained('loads')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rolls', function (Blueprint $table) {
            $table->dropConstrainedForeignId('load_id');
        });

        Schema::dropIfExists('loads');
    }
};
