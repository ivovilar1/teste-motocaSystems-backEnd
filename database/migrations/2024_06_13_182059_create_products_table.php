<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('description');
            // escolhido integer pois fica melhor para trabalhar, os centavos pode ser tornar um problema se nao calcular direito
            // foi adicionado uma funcao auxiliar para fazer o parse de float para int
            $table->integer('price');
            $table->foreignId('category_id')->constrained();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
