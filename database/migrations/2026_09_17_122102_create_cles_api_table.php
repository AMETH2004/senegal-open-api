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
        Schema::create('cles_api', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('nom_application')->nullable();
            $table->string('cle_hash', 64)->unique();
            $table->string('suffixe', 8);
            $table->boolean('actif')->default(true);
            $table->unsignedInteger('nombre_requetes')->default(0);
            $table->timestamp('dernier_acces_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cles_api');
    }
};
