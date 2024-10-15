@extends('auth.index')

@section('titulo')
    <title>JAC | Inicio</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/css/inicio/core.css') }}">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css"> --}}
@endsection
@section('contenido')
    <div class="content-wrapper">

        <section class="content-header d-flex justify-content-between align-items-center">
            <h2>
                Dashboard
                <small>| Inicio</small>
            </h2>
            <!-- Botón de refresco alineado a la derecha -->
            <div>
                <a href="javascript:void(0)" class="btn-m btn-secondary-m" onclick="window.location.reload();">
                    <i class="fa fa-refresh"></i> Refrescar | Dashboard
                </a>
            </div>
        </section>
        <br>
        {{-- Cargando --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-3 mb-4">
                    <div class="container rounded"
                        style="background-color: #ffffff; padding: 20px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); text-align: center;
                        border-radius:35px !important;">
                        <form id="filtro-form" action="{{ route('auth.inicio') }}" method="GET">
                            <div class="form-group">
                                <label for="fecha_desde" class="m-0 label-primary">Mostrar desde</label>
                                <input type="date" class="form-control form-control-sm" id="fecha_desde"
                                    name="fecha_desde" value="{{ request()->input('fecha_desde', date('Y-m-d')) }}">
                                @error('fecha_desde')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="fecha_hasta" class="m-0 label-primary">Mostrar hasta</label>
                                <input type="date" class="form-control form-control-sm" id="fecha_hasta"
                                    name="fecha_hasta" value="{{ request()->input('fecha_hasta', date('Y-m-d')) }}">
                                @error('fecha_hasta')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" id="filtro-submit" class="btn btn-primary btn-sm"
                                    style="border-color: #2ecc71; border-radius: 5px;">Aplicar Filtro</button>
                                <div id="loading" style="display: none;">
                                    Cargando...
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- Remaining content (totals) goes here --}}
                <div class="col-lg-3 mb-4 zoom-container">
                    <div class="totales text-center"
                        style="background: linear-gradient(to bottom right, #34495e, #536f8b);">
                        <div class="title">
                            <p class="title-text" style="color:rgb(255, 255, 255)">
                                <i class="fa fa-user"></i> Total de Empleados
                                <span class="icon-up"><i class="fa fa-arrow-up"></i></span>
                            </p>
                        </div>
                        <div class="data">
                            <p id="totalAsistentes" style="color: white">
                                {{ $totalEmpleados }}
                            </p>
                            <div class="range">
                                <div class="fill" style="background-color: #00e272 !important;"></div>
                            </div>
                        </div>
                        <div style="margin-top: 10px;"> <!-- Espacio entre contenido principal y enlace -->
                            <a href="{{ route('auth.empleado') }}" class="ver-mas"
                                style="color: white; text-decoration: none; margin-top: 10px;">
                                Ver más <i class="fa fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-4 zoom-container">
                    <div class="totales text-center"
                        style="background: linear-gradient(to bottom right, #34495e, #536f8b);">
                        <div class="title">
                            <p class="title-text" style="color:rgb(255, 255, 255)">
                                <i class="fa fa-user"></i> Total de Cargos
                                <span class="icon-up"><i class="fa fa-arrow-up"></i></span>
                            </p>
                        </div>
                        <div class="data">
                            <p id="totalAsistentes" style="color: white">
                                {{ $totalCargos }}
                            </p>
                            <div class="range">
                                <div class="fill" style="background-color: #00e272 !important;"></div>
                            </div>
                        </div>
                        <div style="margin-top: 10px;"> <!-- Espacio entre contenido principal y enlace -->
                            <a href="{{ route('auth.cargo') }}" class="ver-mas"
                                style="color: white; text-decoration: none; margin-top: 10px;">
                                Ver más <i class="fa fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-4 zoom-container">
                    <div class="totales text-center"
                        style="background: linear-gradient(to bottom right, #34495e, #536f8b);">
                        <div class="title">
                            <p class="title-text" style="color:rgb(255, 255, 255)">
                                <i class="fa fa-user"></i> Total de Asistencias
                                <span class="icon-up"><i class="fa fa-arrow-up"></i></span>
                            </p>
                        </div>
                        <div class="data">
                            <p id="totalAsistencias" style="color: white">
                                {{ $totalAsistencias }}
                            </p>
                            <div class="range">
                                <div class="fill" style="background-color: #00e272 !important;"></div>
                            </div>
                        </div>
                        <div style="margin-top: 10px;"> <!-- Espacio entre contenido principal y enlace -->
                            <a href="{{ route('auth.asistencia') }}" class="ver-mas"
                                style="color: white; text-decoration: none; margin-top: 10px;">
                                Ver más <i class="fa fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-lg-9">
                <div class="alert alert-success" role="alert">
                    <span class="fa fa-check-circle"></span>
                    Por favor, aplique filtros por fecha para visualizar gráficos e indicadores actualizados.
                </div>
            </div>
        </div>
        <br>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="content-header"
                        style="box-shadow: 0 2px 25px -5px rgba(0, 0, 0, .16), 0 25px 21px -5px rgba(0, 0, 0, .1) !important;">
                        <div id="container"></div>
                    </div>
                </div>
                <div class="col-lg-12 mb-4">
                    <div class="content-header"
                        style="box-shadow: 0 2px 25px -5px rgba(0, 0, 0, .16), 0 25px 21px -5px rgba(0, 0, 0, .1) !important;">
                        <div id="faltas"></div>
                    </div>
                </div>
            </div>
        </div>
        <br>

    </div>
@endsection

@section('scripts')
    <!-- Incluir archivos de Highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script type="text/javascript" src="{{ asset('auth/js/inicio/index.js') }}"></script>

    <script type="text/javascript">
        // Obtener los datos proporcionados por el controlador
        var getTopFaltasPorEmpleado = @json($getTopFaltasPorEmpleado);
        var getTopFaltas = @json($getTopFaltas);

        // Verificar los datos en la consola
        console.log('Datos de faltas por empleado:', getTopFaltasPorEmpleado);
        console.log('Datos de faltas:', getTopFaltas);

        // Función para transformar datos a números
        function transformData(data) {
            return data.map(item => {
                const faltas = Number(item.faltas); // Convertir a número
                if (isNaN(faltas)) {
                    console.warn(`Valor no numérico encontrado para ${item.nombre}: ${item.faltas}`);
                    return { name: item.nombre, y: 0 }; // Asignar 0 si no es un número
                }
                return {
                    name: item.nombre,
                    y: faltas // Asignar el valor convertido
                };
            }).filter(item => item.y > 0); // Filtrar datos válidos
        }

        // Comprobar datos transformados
        const transformedFaltasPorEmpleado = transformData(getTopFaltasPorEmpleado);
        const transformedFaltas = transformData(getTopFaltas);

        console.log('Datos transformados de faltas por empleado:', transformedFaltasPorEmpleado);
        console.log('Datos transformados de faltas:', transformedFaltas);

        // Validar datos antes de graficar
        if (!transformedFaltasPorEmpleado.length || !transformedFaltas.length) {
            console.error("No hay datos válidos para graficar.");
        } else {
            // Configurar el gráfico de Highcharts para Tardanzas
            Highcharts.chart('container', {
                chart: {
                    type: 'column' // Gráfico de barras
                },
                title: {
                    text: 'Cantidad de Tardanzas por Empleado'
                },
                xAxis: {
                    type: 'category',
                    title: {
                        text: 'Empleados'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Cantidad de Tardanzas'
                    }
                },
                tooltip: {
                    pointFormat: 'Tardanzas: <b>{point.y}</b>'
                },
                series: [{
                    name: 'Cantidad',
                    data: transformedFaltasPorEmpleado, // Datos transformados
                    colorByPoint: true
                }]
            });

            // Configurar el gráfico de Highcharts para Faltas
            Highcharts.chart('faltas', {
                chart: {
                    type: 'column' // Gráfico de barras
                },
                title: {
                    text: 'Cantidad de Faltas por Empleado'
                },
                xAxis: {
                    type: 'category',
                    title: {
                        text: 'Empleados'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Cantidad de Faltas'
                    }
                },
                tooltip: {
                    pointFormat: 'Faltas: <b>{point.y}</b>'
                },
                series: [{
                    name: 'Cantidad',
                    data: transformedFaltas, // Datos transformados
                    colorByPoint: true
                }]
            });
        }
    </script>
@endsection


