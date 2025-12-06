<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('respuestas_valoracion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('valoracion_id')->constrained('valoraciones')->onDelete('cascade');
            $table->foreignId('item_escala_id')->constrained('items_escala');
            $table->foreignId('opcion_escala_id')->constrained('opciones_escala');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('respuestas_valoracion');
    }
};
