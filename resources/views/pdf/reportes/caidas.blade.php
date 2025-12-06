<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Caídas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; color: #666; }
        .stats { display: flex; justify-content: space-around; margin: 15px 0; }
        .stat-box { text-align: center; padding: 10px; background: #f5f5f5; border-radius: 5px; flex: 1; margin: 0 5px; }
        .stat-box .number { font-size: 24px; font-weight: bold; color: #dc2626; }
        .stat-box .label { font-size: 10px; color: #666; margin-top: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #333; color: white; padding: 8px; text-align: left; font-size: 11px; }
        td { padding: 6px; border-bottom: 1px solid #ddd; font-size: 11px; }
        tr:nth-child(even) { background: #f9f9f9; }
        .badge { padding: 3px 8px; border-radius: 3px; font-size: 10px; font-weight: bold; }
        .badge-si { background: #fee2e2; color: #991b1b; }
        .badge-no { background: #d1fae5; color: #065f46; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE DE CAÍDAS</h1>
        <p>Sistema de Supervisión de Enfermería</p>
        <p>Generado: {{ $fecha_generacion->format('d/m/Y H:i') }}</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <div class="number">{{ $estadisticas['total'] }}</div>
            <div class="label">Total de Caídas</div>
        </div>
        <div class="stat-box">
            <div class="number">{{ $estadisticas['con_lesion'] }}</div>
            <div class="label">Con Lesión</div>
        </div>
        <div class="stat-box">
            <div class="number">{{ $estadisticas['total'] > 0 ? round(($estadisticas['con_lesion'] / $estadisticas['total']) * 100, 1) : 0 }}%</div>
            <div class="label">% Con Lesión</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Paciente</th>
                <th>Turno</th>
                <th>Hora</th>
                <th>Lugar</th>
                <th>Tipo de Caída</th>
                <th>Lesión</th>
            </tr>
        </thead>
        <tbody>
            @foreach($caidas as $caida)
                <tr>
                    <td>{{ $caida->fecha->format('d/m/Y') }}</td>
                    <td>{{ $caida->admision->paciente->nombre }}</td>
                    <td>{{ $caida->turno }}</td>
                    <td>{{ $caida->hora_caida }}</td>
                    <td>{{ $caida->lugar }}</td>
                    <td>{{ $caida->tipo_caida }}</td>
                    <td>
                        <span class="badge badge-{{ $caida->hubo_lesion ? 'si' : 'no' }}">
                            {{ $caida->hubo_lesion ? 'Sí' : 'No' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Este documento fue generado automáticamente por el Sistema de Supervisión de Enfermería</p>
    </div>
</body>
</html>
