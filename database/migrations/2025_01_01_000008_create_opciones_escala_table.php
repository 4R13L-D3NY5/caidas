<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opciones_escala', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_escala_id')->constrained('items_escala')->onDelete('cascade');
            $table->string('criterio'); // Ej: "Ninguna caída"
            $table->integer('puntaje');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opciones_escala');
    }
};
