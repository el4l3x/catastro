@extends('adminlte::page')

@section('title', 'Ciudadanos')

@section('content_header')
    <h1>Editar Ciudadano {{ $ciudadano->nombres }} {{ $ciudadano->apellidos }}</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <form action="{{ route("ciudadanos.update", $ciudadano) }}" method="post">
                        @method('PUT')
                        @csrf
                        <h5>Datos Personales</h5>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <hr>

                        @livewire('archivo.ciudadanos.create', [
                            'ciudadanoOld' => $ciudadano
                        ])

                        <div class="row">

                            @php
                            $config = ['format' => 'DD-MM-YYYY'];
                            @endphp
                            <x-adminlte-input-date value="{{ date('d-m-Y', strtotime($ciudadano->nacimiento)) }}" name="nacimiento" label="Fecha de Nacimiento" enable-old-support fgroup-class="col-lg-2 col-md-2 col-sm-6" :config="$config"/>
                            
                            @if ($ciudadano->sexo == 'M')
                            <x-adminlte-input-switch name="sexo" label="Sexo" enable-old-support fgroup-class="col-lg-2 col-md-4 col-sm-6" data-on-text="M" data-off-text="F" data-on-color="teal" data-off-color="pink" checked/>
                            @else
                            <x-adminlte-input-switch name="sexo" label="Sexo" enable-old-support fgroup-class="col-lg-2 col-md-4 col-sm-6" data-on-text="M" data-off-text="F" data-on-color="teal" data-off-color="pink"/>
                            @endif

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Jefe de familia">Es Jefe de Familia?</label>
                        
                                    <div class="input-group">
                                        <div class="form-check">
                                            @if ($jefe != NULL)
                                                @if ($ciudadano->id === $jefe->ciudadano_id)
                                                <input type="checkbox" name="jefe" id="jefe" class="form-check-input" checked>
                                                @else
                                                <input type="checkbox" name="jefe" id="jefe" class="form-check-input">
                                                @endif
                                            @else
                                                <input type="checkbox" name="jefe" id="jefe" class="form-check-input">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5" id="colJefe">
                                <label class="" for="Jefe de familia">Seleccione su Jefe de Familia</label>
                            
                                <div class="input-group">
                    
                                    <select name="jfamilia" id="jfamilia" class="form-control">
                                        @if ($jefe != NULL)
                                        <option value="{{$jefe->id}}" selected="selected">{{$jefe->datos->nacionalidad}}-{{$jefe->datos->cedula}} {{$jefe->datos->nombres}}, {{$jefe->datos->apellidos}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-5 d-none" id="colFamilia">
                                <label class="" for="Jefe de familia">Seleccione su Familia</label>
                            
                                <div class="input-group">
                    
                                    <select name="familia[]" id="familia" class="form-control" multiple>
                                        @if ($ciudadano->familia->count() > 0)
                                            @foreach ($jefe->familia as $miembro)
                                                @if ($ciudadano->id != $miembro->id)                                                    
                                                    <option value="{{$miembro->id}}" selected="selected">{{$miembro->nacionalidad}}-{{$miembro->cedula}} {{$miembro->nombres}}, {{$miembro->apellidos}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                    
                        </div>

                        <h5>Ubicacion</h5>
                        <hr>

                        <div class="row">
                            @php
                            $configu = [
                                "placeholder" => "",
                                "allowClear" => false,
                                "liveSearch" => true,
                                "liveSearchPlaceholder" => "Buscar...",
                                "title" => "Selecciona la parroquia...",
                                "showTick" => false,
                                "actionsBox" => false,
                            ];
                            @endphp
                            <x-adminlte-select2 id="parroquia" name="parroquia" label="Parroquia" :config="$configu" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12">
                                @foreach ($parroquias as $parroquia)
                                    @if ($ciudadano->parroquia_id == $parroquia->id)
                                    <option selected value="{{ $parroquia->id }}">{{ $parroquia->nombre }}</option>    
                                    @else                                        
                                    <option value="{{ $parroquia->id }}">{{ $parroquia->nombre }}</option>
                                    @endif
                                @endforeach
                            </x-adminlte-select2>

                            <x-adminlte-input value="{{ $ciudadano->direccion }}" name="direccion" label="Dirección" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12"/>
                            <x-slot name="bottomSlot">
                                @error('sector')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </x-slot>
                        </div>

                        @livewire('archivo.ciudadanos.concejo', [
                            'concejoOld' => $ciudadano->concejo_id,
                            'comunaOld' => $ciudadano->concejo->comuna->id,
                        ])
                        
                        <div class="form-group">
                            <button class="btn btn-gray" type="submit">Guardar</button>
                            <a class="btn btn-gray" role="button" href="{{ route("ciudadanos.index") }}">Volver</a>
                        </div>
                    </form>

                </div>    
            </div>

        </div>
    </div>

@stop

@section('plugins.Select2', true)
@section('plugins.BootstrapSwitch', true)
@section('plugins.TempusDominusBs4', true)

@section('css')
    <style>
        .btn-gray {
            background: #6c757d;
            color: white;
        }
    </style>
@stop

@section('js')    
    <script>        
        $(document).ready(function() {            
            if ($("#jefe").prop('checked')) {
                $("#jfamilia").val(1)
                $("#colJefe").addClass("d-none")
                $("#colFamilia").removeClass("d-none")
            } else {
                $("#colFamilia").addClass("d-none")
                $("#colJefe").removeClass("d-none")
            }

            $("#jefe").change(function () {
                if ($("#jefe").prop('checked')) {
                    $("#colJefe").addClass("d-none")
                    $("#colFamilia").removeClass("d-none")
                } else {
                    $("#colFamilia").addClass("d-none")
                    $("#colJefe").removeClass("d-none")
                }
            })

            $("#jfamilia").select2({
                placeholder: "Selecciona un Jefe de Familia",
                allowClear: true,
                language: {
                    searching: function () {
                        return "Buscando...";
                    },

                    errorLoading: function () {
                        return "No se consiguieron coincidencias...";
                    }
                },
                ajax: {
                    url: "{{ route('select.jefes') }}",
                    dataType: 'json',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function(term) {
                        return {
                            term: term,
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {                                        
                                    text: item.datos.nacionalidad + '-' + item.datos.cedula + ' ' + item.datos.nombres + ', ' + item.datos.apellidos,
                                    id: item.id,
                                }
                            })
                        };
                    }
                }
            });
            
            $("#familia").select2({
                placeholder: "Selecciona tus Miembros de Familia",
                allowClear: true,
                language: {
                    searching: function () {
                        return "Buscando...";
                    },

                    errorLoading: function () {
                        return "No se consiguieron coincidencias...";
                    }
                },
                ajax: {
                    url: "{{ route('select.familia') }}",
                    dataType: 'json',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function(term) {
                        return {
                            term: term,
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.nacionalidad + '-' + item.cedula + ' ' + item.nombres + ', ' + item.apellidos,
                                    id: item.id,
                                }
                            })
                        };
                    }
                }
            });
        });
    </script>
@stop