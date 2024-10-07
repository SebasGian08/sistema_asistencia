@extends('auth.index')

@section('titulo')
    <title>JAC | Aniversario</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
@endsection

@section('contenido')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                Listado de Asistentes
                <small>Aniversario</small>
            </h1>
        </section>

        <section class="content">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <br><br>
                    <div class="content-header">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label>Desde:</label>
                                <input type="date" id="dateFrom" class="form-control" />
                            </div>
                            <div class="col-md-4">
                                <label>Hasta:</label>
                                <input type="date" id="dateTo" class="form-control" />
                            </div>
                            <div class="col-md-4">
                                <label>&nbsp;</label>
                                <button id="filterButton" class="btn btn-primary form-control">Consultar</button>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="content-header">
                        <table id="tableAniversario"
                            class="table table-bordered table-striped display nowrap margin-top-10 dataTable no-footer">
                        </table>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/js/aniversario/index.js') }}"></script>
@endsection
