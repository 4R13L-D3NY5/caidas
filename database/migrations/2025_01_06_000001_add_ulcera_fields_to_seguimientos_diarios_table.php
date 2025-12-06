<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seguimientos_diarios', function (Blueprint $table) {
            // Campos para úlceras por presión
            $table->boolean('hubo_ulcera')->default(false)->after('hubo_caida');
            $table->string('estado_ulcera')->nullable()->after('hubo_ulcera');
            $table->string('presencia_necrosis')->nullable()->after('estado_ulcera');
            $table->text('descripcion_ulcera')->nullable()->after('presencia_necrosis');
            $table->string('ubicacion_ulcera')->nullable()->after('descripcion_ulcera');
            $table->text('observaciones_ulcera')->nullable()->after('ubicacion_ulcera');
        });
    }

    public function down(): void
    {
        Schema::table('seguimientos_diarios', function (Blueprint $table) {
            $table->dropColumn([
                'hubo_ulcera',
                'estado_ulcera',
                'presencia_necrosis',
                'descripcion_ulcera',
                'ubicacion_ulcera',
                'observaciones_ulcera'
            ]);
        });
    }
};
