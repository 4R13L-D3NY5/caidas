<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Estadístico</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; }
        .period { background: #f5f5f5; padding: 10px; text-align: center; margin-bottom: 15px; border-radius: 5px; }
        .stats { display: flex; justify-content: space-around; margin: 15px 0; }
        .stat-box { text-align: center; padding: 15px; background: #f5f5f5; border-radius: 5px; flex: 1; margin: 0 5px; }
        .stat-box .number { font-size: 28px; font-weight: bold; }
        .stat-box .label { font-size: 10px; color: #666; margin-top: 5px; }
        .section { margin: 20px 0; }
        .section h3 { font-size: 14px; border-bottom: 1px solid #333; padding-bottom: 5px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #333; color: white; padding: 8px; text-align: left; font-size: 11px; }
        td { padding: 6px; border-bottom: 1px solid #ddd; }
        .risk-grid { display: flex; justify-content: space-around; margin: 15px 0; }
        .risk-box { text-align: center; padding: 15px; border-radius: 5px; flex: 1; margin: 0 5px; }
        .risk-bajo { background: #d1fae5; color: #065f46; }
        .risk-moderado { background: #fef3c7; color: #92400e; }
        .risk-alto { background: #fed7aa; color: #9a3412; }
        .risk-muy-alto { background: #fee2e2; color: #991b1b; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE ESTADÍSTICO GENERAL</h1>
        <p>Sistema de Supervisión de Enfermería</p>
        <p>Generado: {{ $fecha_generacion->format('d/m/Y H:i') }}</p>
    </div>

    <div class="period">
        <strong>Período:</strong> {{ \Carbon\Carbon::parse($datos['periodo']['inicio'])->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($datos['periodo']['fin'])->format('d/m/Y') }}
    </div>

    <div class="stats">
        <div class="stat-box">
            <div class="number" style="color: #2563eb;">{{ $datos['admisiones']['total'] }}</div>
            <div class="label">Total Admisiones</div>
            <div style="font-size: 10px; margin-top: 5px;">Activas: {{ $datos['admisiones']['activas'] }} | Altas: {{ $datos['admisiones']['altas'] }}</div>
        </div>
        <div class="stat-box">
            <div class="number" style="color: #dc2626;">{{ $datos['caidas']['total'] }}</div>
            <div class="label">Total Caídas</div>
            <div style="font-size: 10px; margin-top: 5px;">Con lesión: {{ $datos['caidas']['con_lesion'] }}</div>
        </div>
        <div class="stat-box">
            <div class="number" style="color: #059669;">{{ $datos['cumplimiento'] }}%</div>
            <div class="label">Cumplimiento Promedio</div>
        </div>
    </div>

    <div class="section">
        <h3>Admisiones por Tipo</h3>
        <table>
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos['admisiones']['por_tipo'] as $tipo => $cantidad)
                    <tr>
                        <td>{{ $tipo === 'caida' ? 'Caídas' : 'Úlceras por Presión' }}</td>
                        <td><strong>{{ $cantidad }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Caídas por Turno</h3>
        <table>
            <thead>
                <tr>
                    <th>Turno</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos['caidas']['por_turno'] as $turno => $cantidad)
                    <tr>
                        <td>{{ $turno }}</td>
                        <td><strong>{{ $cantidad }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Distribución por Nivel de Riesgo</h3>
        <div class="risk-grid">
            @foreach($datos['distribucion_riesgo'] as $nivel => $cantidad)
                <div class="risk-box risk-{{ 
                    $nivel === 'Riesgo Bajo' ? 'bajo' : 
                    ($nivel === 'Riesgo Moderado' ? 'moderado' : 
                    ($nivel === 'Riesgo Alto' ? 'alto' : 'muy-alto')) 
                }}">
                    <div style="font-size: 24px; font-weight: bold;">{{ $cantidad }}</div>
                    <div style="font-size: 10px; margin-top: 5px;">{{ $nivel }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="footer">
        <p>Este documento fue generado automáticamente por el Sistema de Supervisión de Enfermería</p>
    </div>
</body>
</html>
