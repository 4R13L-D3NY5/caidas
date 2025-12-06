<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items_lista_cotejo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lista_cotejo_id')->constrained('listas_cotejo')->onDelete('cascade');
            $table->foreignId('accion_recomendada_id')->constrained('acciones_recomendadas');
            $table->boolean('aplicada')->default(false);
            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items_lista_cotejo');
    }
};
