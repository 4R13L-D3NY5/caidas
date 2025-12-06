<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seguimientos_diarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admision_id')->constrained('admisiones')->onDelete('cascade');
            $table->date('fecha');
            $table->string('turno');
            $table->boolean('hubo_caida')->default(false);
            
            // Campos adicionales si hubo caída
            $table->time('hora_caida')->nullable();
            $table->string('lugar')->nullable(); // Cama, Baño, Pasillo, Otro
            $table->string('tipo_caida')->nullable(); // Propia altura, desde cama, etc.
            $table->boolean('hubo_lesion')->nullable();
            $table->text('descripcion_lesion')->nullable();
            $table->json('acciones_tomadas')->nullable(); // Array de acciones
            $table->text('observacion')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seguimientos_diarios');
    }
};
