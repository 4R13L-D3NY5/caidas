<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Cumplimiento</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; }
        .stats { display: flex; justify-content: space-around; margin: 15px 0; }
        .stat-box { text-align: center; padding: 10px; background: #f5f5f5; border-radius: 5px; flex: 1; margin: 0 5px; }
        .stat-box .number { font-size: 24px; font-weight: bold; color: #059669; }
        .stat-box .label { font-size: 10px; color: #666; margin-top: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #333; color: white; padding: 8px; text-align: left; font-size: 11px; }
        td { padding: 6px; border-bottom: 1px solid #ddd; font-size: 11px; }
        .progress-bar { background: #e5e7eb; height: 10px; border-radius: 5px; overflow: hidden; }
        .progress-fill { height: 100%; }
        .progress-high { background: #059669; }
        .progress-medium { background: #eab308; }
        .progress-low { background: #dc2626; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE DE CUMPLIMIENTO</h1>
        <p>Sistema de Supervisión de Enfermería</p>
        <p>Generado: {{ $fecha_generacion->format('d/m/Y H:i') }}</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <div class="number">{{ $estadisticas['total_verificaciones'] }}</div>
            <div class="label">Total Verificaciones</div>
        </div>
        <div class="stat-box">
            <div class="number">{{ number_format($estadisticas['promedio_cumplimiento'], 1) }}%</div>
            <div class="label">Promedio Cumplimiento</div>
        </div>
        <div class="stat-box">
            <div class="number">{{ $estadisticas['cumplimiento_alto'] }}</div>
            <div class="label">Alto (≥80%)</div>
        </div>
        <div class="stat-box">
            <div class="number">{{ $estadisticas['cumplimiento_bajo'] }}</div>
            <div class="label">Bajo (<60%)</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Paciente</th>
                <th>Supervisor</th>
                <th>Cumplimiento</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listas as $lista)
                <tr>
                    <td>{{ $lista->fecha_verificacion->format('d/m/Y H:i') }}</td>
                    <td>{{ $lista->admision->paciente->nombre }}</td>
                    <td>{{ $lista->supervisor->name }}</td>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill progress-{{ $lista->porcentaje_cumplimiento >= 80 ? 'high' : ($lista->porcentaje_cumplimiento >= 60 ? 'medium' : 'low') }}" 
                                style="width: {{ $lista->porcentaje_cumplimiento }}%"></div>
                        </div>
                        {{ $lista->porcentaje_cumplimiento }}%
                    </td>
                    <td>{{ $lista->observaciones ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Este documento fue generado automáticamente por el Sistema de Supervisión de Enfermería</p>
    </div>
</body>
</html>
