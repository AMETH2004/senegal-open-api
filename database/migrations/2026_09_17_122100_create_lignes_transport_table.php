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
        Schema::create('lignes_transport', function (Blueprint $table) {
            $table->id();
            $table->foreignId('operateur_id')->constrained('operateurs_transport')->cascadeOnDelete();
            $table->string('numero');
            $table->string('nom');
            $table->foreignId('origine_commune_id')->nullable()->constrained('communes')->nullOnDelete();
            $table->foreignId('destination_commune_id')->nullable()->constrained('communes')->nullOnDelete();
            $table->timestamps();

            $table->unique(['operateur_id', 'numero']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lignes_transport');
    }
};
