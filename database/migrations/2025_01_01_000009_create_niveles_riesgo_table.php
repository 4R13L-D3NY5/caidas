<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('niveles_riesgo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escala_id')->constrained('escalas')->onDelete('cascade');
            $table->string('nombre'); // Ej: "Riesgo Bajo"
            $table->integer('puntaje_min');
            $table->integer('puntaje_max');
            $table->string('color'); // verde, amarillo, rojo
            $table->string('codigo_color')->nullable(); // hex o emoji
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('niveles_riesgo');
    }
};
