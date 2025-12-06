<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acciones_recomendadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nivel_riesgo_id')->constrained('niveles_riesgo')->onDelete('cascade');
            $table->text('descripcion');
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acciones_recomendadas');
    }
};
