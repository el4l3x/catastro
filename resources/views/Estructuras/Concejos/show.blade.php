@extends('adminlte::page')

@section('title', 'Concejos Comunales')

@section('content_header')
    <h1>Concejo Comunal {{ $concejo->nombre }} de la Comuna {{ $concejo->comuna->nombre }} - Informe detallado</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-6">

                    <div class="card">
                        
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h2 class="card-title">Poblacion</h2>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">{{$poblacion}}</span>
                                    <span>Ciudadanos Totales</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    @if (($poblacion-$aumentop) == 0)
                                    <span class="text-primary">
                                        <i class="fas fa-arrow-up"></i> {{$aumentop}}<i class="fas fa-users"></i>
                                    </span>
                                    @else
                                    <span class="text-primary">
                                        <i class="fas fa-arrow-up"></i> {{$aumentop}}<i class="fas fa-users"></i> - {{number_format(($aumentop*100)/($poblacion-$aumentop), '2')}}%
                                    </span>
                                    @endif
                                    <span class="text-muted">En la ultima semana</span>
                                </p>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-primary text-xl">
                                    <i class="fas fa-male"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <i class="fas fa-male"></i> {{$genero}}
                                    </span>
                                    <span class="text-muted">Poblacion Masculina</span>
                                </p>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-primary text-xl">
                                    <i class="fas fa-female"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <i class="fas fa-female"></i> {{$poblacion-$genero}}
                                    </span>
                                    <span class="text-muted">Poblacion Femenina</span>
                                </p>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-primary text-xl">
                                    <i class="fas fa-child"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <i class="fas fa-child"></i> {{$edadm}}
                                    </span>
                                    <span class="text-muted">Menores de Edad</span>
                                </p>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-primary text-xl">
                                    <i class="fas fa-blind"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <i class="fas fa-blind"></i> {{$abuelos}}
                                    </span>
                                    <span class="text-muted">Ciudadanos de la 3ra Edad</span>
                                </p>
                            </div>
                            
                        </div>
                    </div>

                </div>
                
                <div class="col-md-6">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Distribucion de Población</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="container"></div>
                        </div>
                    </div>

                </div>    
            </div>

        </div>
    </div>

@stop

@section('css')
    <style>
        
    </style>
@stop

@section('js')    
    <script src="/src/Highcharts/highcharts.js"></script>
    <script>
        var poblacion = {{ Js::from($poblacion) }};     
        var aumentop = {{ Js::from($aumentop) }};     
        var genero = {{ Js::from($genero) }};     
        var edadm = {{ Js::from($edadm) }};     
        var abuelos = {{ Js::from($abuelos) }};
        
        var pm = (genero*100)/poblacion;
        var pf = ((poblacion-genero)*100)/poblacion;
        var pme = (edadm*100)/poblacion;
        var pa = (abuelos*100)/poblacion;
        Highcharts.chart('container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'Masculino',
                    y: pm,
                    sliced: true,
                }, {
                    name: 'Femenino',
                    y: pf,
                    sliced: true,
                }, {
                    name: 'Menores de Edad',
                    y: pme,
                    sliced: true,
                }, {
                    name: '3ra Edad',
                    y: pa,
                    sliced: true,
                }]
            }]
        });
    </script>
@stop