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
        Schema::create('ligne_arret', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ligne_transport_id')->constrained('lignes_transport')->cascadeOnDelete();
            $table->foreignId('arret_id')->constrained('arrets')->cascadeOnDelete();
            $table->unsignedSmallInteger('ordre');
            $table->timestamps();

            $table->unique(['ligne_transport_id', 'arret_id']);
            $table->unique(['ligne_transport_id', 'ordre']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ligne_arret');
    }
};
