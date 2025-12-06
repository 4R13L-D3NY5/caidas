<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Pacientes</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; color: #666; }
        .filters { background: #f5f5f5; padding: 10px; margin-bottom: 15px; border-radius: 5px; }
        .filters p { margin: 3px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #333; color: white; padding: 8px; text-align: left; font-size: 11px; }
        td { padding: 6px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background: #f9f9f9; }
        .badge { padding: 3px 8px; border-radius: 3px; font-size: 10px; font-weight: bold; }
        .badge-activo { background: #dbeafe; color: #1e40af; }
        .badge-alta { background: #d1fae5; color: #065f46; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE DE PACIENTES</h1>
        <p>Sistema de Supervisión de Enfermería</p>
        <p>Generado: {{ $fecha_generacion->format('d/m/Y H:i') }}</p>
    </div>

    <div class="filters">
        <strong>Filtros Aplicados:</strong>
        @if(!empty($filtros['estado']) && $filtros['estado'] !== 'todos')
            <p>Estado: {{ ucfirst($filtros['estado']) }}</p>
        @endif
        @if(!empty($filtros['tipo']) && $filtros['tipo'] !== 'todos')
            <p>Tipo: {{ $filtros['tipo'] === 'caida' ? 'Caídas' : 'Úlceras' }}</p>
        @endif
        @if(!empty($filtros['fecha_inicio']))
            <p>Desde: {{ \Carbon\Carbon::parse($filtros['fecha_inicio'])->format('d/m/Y') }}</p>
        @endif
        @if(!empty($filtros['fecha_fin']))
            <p>Hasta: {{ \Carbon\Carbon::parse($filtros['fecha_fin'])->format('d/m/Y') }}</p>
        @endif
    </div>

    <p><strong>Total de pacientes:</strong> {{ $pacientes->count() }}</p>

    <table>
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Matrícula</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Nivel de Riesgo</th>
                <th>Fecha Ingreso</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pacientes as $admision)
                @php
                    $valoracion = $admision->valoraciones->where('tipo_valoracion', 'inicial')->first();
                @endphp
                <tr>
                    <td>{{ $admision->paciente->nombre }}</td>
                    <td>{{ $admision->paciente->matricula }}</td>
                    <td>{{ $admision->tipo === 'caida' ? 'Caídas' : 'Úlceras' }}</td>
                    <td>
                        <span class="badge badge-{{ $admision->estado }}">{{ ucfirst($admision->estado) }}</span>
                    </td>
                    <td>
                        @if($valoracion)
                            {{ $valoracion->nivelRiesgo->nombre }}
                        @endif
                    </td>
                    <td>{{ $admision->fecha_valoracion->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Este documento fue generado automáticamente por el Sistema de Supervisión de Enfermería</p>
    </div>
</body>
</html>
