<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('listas_cotejo', function (Blueprint $table) {
            $table->boolean('llamada_atencion')->default(false)->after('porcentaje_cumplimiento');
        });
    }

    public function down(): void
    {
        Schema::table('listas_cotejo', function (Blueprint $table) {
            $table->dropColumn('llamada_atencion');
        });
    }
};
