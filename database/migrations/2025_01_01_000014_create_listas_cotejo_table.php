<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listas_cotejo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admision_id')->constrained('admisiones')->onDelete('cascade');
            $table->foreignId('seguimiento_diario_id')->constrained('seguimientos_diarios')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users'); // Supervisora que verifica
            $table->date('fecha_verificacion');
            $table->decimal('porcentaje_cumplimiento', 5, 2)->default(0);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listas_cotejo');
    }
};
