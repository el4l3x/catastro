@extends('adminlte::page')

@section('title', 'Ciudadanos')

@section('content_header')
    <h1>Nuevo Ciudadano</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <form action="{{ route("ciudadanos.store") }}" method="post">
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

                        @livewire('archivo.ciudadanos.create')

                        <div class="row">

                            <x-adminlte-input-switch name="sexo" label="Sexo" enable-old-support fgroup-class="col-lg-2 col-md-2 col-sm-6" data-on-text="M" data-off-text="F" data-on-color="teal" data-off-color="pink" checked/>
    
                            @php
                            $config = ['format' => 'DD-MM-YYYY'];
                            @endphp
                            <x-adminlte-input-date name="nacimiento" label="Fecha de Nacimiento" enable-old-support fgroup-class="col-lg-2 col-md-4 col-sm-6" :config="$config"/>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Jefe de familia">Es Jefe de Familia?</label>
                        
                                    <div class="input-group">
                                        <div class="form-check">
                                            <input type="checkbox" name="jefe" id="jefe" class="form-check-input">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5" id="colJefe">
                                <label class="" for="Jefe de familia">Seleccione su Jefe de Familia</label>
                            
                                <div class="input-group">
                    
                                    <select name="jfamilia" id="jfamilia" class="form-control">
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-5 d-none" id="colFamilia">
                                <label class="" for="Jefe de familia">Seleccione su Familia</label>
                            
                                <div class="input-group">
                    
                                    <select name="familia[]" id="familia" class="form-control" multiple>
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
                                    <option value="{{ $parroquia->id }}">{{ $parroquia->nombre }}</option>
                                @endforeach
                            </x-adminlte-select2>

                            <x-adminlte-input name="direccion" label="Dirección" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12"/>
                            <x-slot name="bottomSlot">
                                @error('sector')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </x-slot>
                        </div>

                        @livewire('archivo.ciudadanos.concejo')                        
                        
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