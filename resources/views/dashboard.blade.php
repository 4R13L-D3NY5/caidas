<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @php
                $pacientesActivos = \App\Models\Admision::where('estado', 'activo')->count();
                $pacientesAlta = \App\Models\Admision::where('estado', 'alta')->count();
                $totalPacientes = $pacientesActivos + $pacientesAlta;
                
                $caidasHoy = \App\Models\SeguimientoDiario::whereDate('fecha', today())->where('hubo_caida', true)->count();
                
                // Estadísticas por tipo
                $activosCaidas = \App\Models\Admision::where('estado', 'activo')->where('tipo', 'caida')->count();
                $activosUlceras = \App\Models\Admision::where('estado', 'activo')->where('tipo', 'ulcera')->count();
                
                // Niveles de riesgo
                $riesgosActivos = \App\Models\Admision::with('valoraciones.nivelRiesgo')
                    ->where('estado', 'activo')
                    ->get()
                    ->map(function($admision) {
                        $valoracion = $admision->valoraciones->where('tipo_valoracion', 'inicial')->first();
                        return $valoracion ? $valoracion->nivelRiesgo->nombre : null;
                    })
                    ->filter()
                    ->countBy()
                    ->toArray();
                
                // Caídas últimos 7 días
                $caidasSemana = \App\Models\SeguimientoDiario::where('hubo_caida', true)
                    ->whereBetween('fecha', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
                    ->selectRaw('DATE(fecha) as dia, COUNT(*) as total')
                    ->groupBy('dia')
                    ->orderBy('dia')
                    ->get();
                
                // Cumplimiento promedio
                $cumplimientoPromedio = \App\Models\ListaCotejo::avg('porcentaje_cumplimiento') ?? 0;
                
                // Total de caídas
                $totalCaidas = \App\Models\SeguimientoDiario::where('hubo_caida', true)->count();
            @endphp

            <!-- Tarjetas de Métricas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Pacientes Activos -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Pacientes Activos</p>
                            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $pacientesActivos }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pacientes de Alta -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Pacientes de Alta</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ $pacientesAlta }}</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Caídas Hoy -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Caídas Hoy</p>
                            <p class="text-3xl font-bold text-red-600 mt-2">{{ $caidasHoy }}</p>
                        </div>
                        <div class="bg-red-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Pacientes -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Pacientes</p>
                            <p class="text-3xl font-bold text-purple-600 mt-2">{{ $totalPacientes }}</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Gráfico de Torta: Distribución por Tipo -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribución de Pacientes Activos por Tipo</h3>
                    <div style="height: 300px; position: relative;">
                        <canvas id="tipoChart"></canvas>
                    </div>
                </div>

                <!-- Gráfico de Barras: Niveles de Riesgo -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Pacientes por Nivel de Riesgo</h3>
                    <div style="height: 300px; position: relative;">
                        <canvas id="riesgoChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Gráficos de Línea y Métricas -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Gráfico de Línea: Caídas Últimos 7 Días -->
                <div class="bg-white rounded-lg shadow-lg p-6 lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Caídas - Últimos 7 Días</h3>
                    <div style="height: 250px; position: relative;">
                        <canvas id="caidasChart"></canvas>
                    </div>
                </div>

                <!-- Métricas Adicionales -->
                <div class="space-y-6">
                    <!-- Cumplimiento Promedio -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-sm font-medium text-gray-600 mb-2">Cumplimiento Promedio</h3>
                        <div class="flex items-end justify-between">
                            <p class="text-3xl font-bold text-blue-600">{{ number_format($cumplimientoPromedio, 1) }}%</p>
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="mt-4 bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $cumplimientoPromedio }}%"></div>
                        </div>
                    </div>

                    <!-- Total de Caídas -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-sm font-medium text-gray-600 mb-2">Total de Caídas Registradas</h3>
                        <div class="flex items-end justify-between">
                            <p class="text-3xl font-bold text-red-600">{{ $totalCaidas }}</p>
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Configuración global para desactivar animaciones
        Chart.defaults.animation = false;

        // Gráfico de Torta: Distribución por Tipo
        const tipoCtx = document.getElementById('tipoChart').getContext('2d');
        new Chart(tipoCtx, {
            type: 'doughnut',
            data: {
                labels: ['Caídas', 'Úlceras por Presión'],
                datasets: [{
                    data: [{{ $activosCaidas }}, {{ $activosUlceras }}],
                    backgroundColor: ['#3b82f6', '#10b981'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Gráfico de Barras: Niveles de Riesgo
        const riesgoCtx = document.getElementById('riesgoChart').getContext('2d');
        new Chart(riesgoCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($riesgosActivos)) !!},
                datasets: [{
                    label: 'Pacientes',
                    data: {!! json_encode(array_values($riesgosActivos)) !!},
                    backgroundColor: ['#22c55e', '#eab308', '#f97316', '#ef4444'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Gráfico de Línea: Caídas Últimos 7 Días
        const caidasCtx = document.getElementById('caidasChart').getContext('2d');
        const diasSemana = [];
        const caidasData = [];
        
        // Generar últimos 7 días
        for (let i = 6; i >= 0; i--) {
            const fecha = new Date();
            fecha.setDate(fecha.getDate() - i);
            const diaFormato = fecha.toISOString().split('T')[0];
            diasSemana.push(fecha.toLocaleDateString('es-ES', { weekday: 'short', day: 'numeric' }));
            
            // Buscar caídas para este día
            const caidasDia = {!! json_encode($caidasSemana->pluck('total', 'dia')->toArray()) !!};
            caidasData.push(caidasDia[diaFormato] || 0);
        }

        new Chart(caidasCtx, {
            type: 'line',
            data: {
                labels: diasSemana,
                datasets: [{
                    label: 'Caídas',
                    data: caidasData,
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
