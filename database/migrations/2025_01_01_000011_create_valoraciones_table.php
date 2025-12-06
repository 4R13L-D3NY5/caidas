<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('valoraciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admision_id')->constrained('admisiones')->onDelete('cascade');
            $table->enum('tipo_valoracion', ['inicial', 'alta']);
            $table->integer('puntaje_total');
            $table->foreignId('nivel_riesgo_id')->constrained('niveles_riesgo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('valoraciones');
    }
};
