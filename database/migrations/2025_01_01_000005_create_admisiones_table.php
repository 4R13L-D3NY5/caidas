<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admisiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->enum('tipo', ['caida', 'ulcera']);
            $table->enum('estado', ['activo', 'alta'])->default('activo');
            $table->string('turno');
            $table->date('fecha_valoracion');
            $table->text('diagnostico_inicial');
            $table->text('diagnostico_final')->nullable();
            $table->date('fecha_alta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admisiones');
    }
};
