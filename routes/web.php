<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');
    
    // Gestión de Pacientes
    Route::view('/pacientes/gestion', 'pacientes.gestion')->name('pacientes.gestion');
    Route::view('/paciente/registro', 'pacientes.registro')->name('paciente.registro');
    Route::get('/paciente/{admision}/dashboard', function($admision) {
        return view('pacientes.dashboard', ['admisionId' => $admision]);
    })->name('paciente.dashboard');
    
    // Valoraciones
    Route::get('/valoracion/inicial/{admision}', function($admision) {
        return view('valoraciones.formulario', ['admisionId' => $admision, 'tipo' => 'inicial']);
    })->name('valoracion.inicial');
    
    Route::get('/valoracion/alta/{admision}', function($admision) {
        return view('valoraciones.formulario', ['admisionId' => $admision, 'tipo' => 'alta']);
    })->name('valoracion.alta');
    
    // Seguimiento Diario
    Route::get('/seguimiento/crear/{admision}', function($admision) {
        return view('seguimientos.crear', ['admisionId' => $admision]);
    })->name('seguimiento.crear');
    
    // Historial de Impresión
    Route::get('/paciente/{admision}/historial-impresion', function($admision) {
        return view('pacientes.historial-impresion', ['admisionId' => $admision]);
    })->name('paciente.historial');
    
    // Exportar PDF
    Route::get('/paciente/{admision}/exportar-pdf', [App\Http\Controllers\HistorialPDFController::class, 'exportar'])
        ->name('paciente.exportar-pdf');
    
    // Reportes
    Route::view('/reportes', 'reportes.index')->name('reportes.index');
    Route::post('/reportes/pacientes/pdf', [App\Http\Controllers\ReportePDFController::class, 'pacientes'])->name('reportes.pacientes.pdf');
    Route::post('/reportes/caidas/pdf', [App\Http\Controllers\ReportePDFController::class, 'caidas'])->name('reportes.caidas.pdf');
    Route::post('/reportes/cumplimiento/pdf', [App\Http\Controllers\ReportePDFController::class, 'cumplimiento'])->name('reportes.cumplimiento.pdf');
    Route::post('/reportes/estadistico/pdf', [App\Http\Controllers\ReportePDFController::class, 'estadistico'])->name('reportes.estadistico.pdf');
    
    // Lista de Cotejo (solo supervisora)
    Route::middleware('can:supervisora')->group(function () {
        Route::get('/cotejo/crear/{seguimiento}', function($seguimiento) {
            return view('cotejos.crear', ['seguimientoId' => $seguimiento]);
        })->name('cotejo.crear');
    });
});

require __DIR__.'/auth.php';
