@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <h1>Editar rol {{ $rol->name }}</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <form action="{{ route("roles.update", $rol) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <x-adminlte-input name="nombre" label="Nombre" placeholder="" enable-old-support value="{{ $rol->name }}">
                                <x-slot name="bottomSlot">
                                    @error('nombre')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>
                            </x-adminlte-input>
                        </div>

                        <div class="form-group">
                            @php
                            $config = [
                                "placeholder" => "",
                                "allowClear" => false,
                                "liveSearch" => true,
                                "liveSearchPlaceholder" => "Buscar...",
                                "title" => "Selecciona los permisos...",
                                "showTick" => false,
                                "actionsBox" => false,
                            ];
                            @endphp
                            <x-adminlte-select2 id="permisos" name="permisos[]" label="Permisos" label-class="text-white" igroup-size="md" :config="$config" multiple enable-old-support>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                </x-slot>

                                @foreach ($permisos as $permiso)
                                    @if ($rol->hasPermissionTo($permiso->id))                                        
                                        <option value="{{ $permiso->id }}" selected>{{ $permiso->description }}</option>                                        
                                    @else
                                        <option value="{{ $permiso->id }}">{{ $permiso->description }}</option>                                        
                                    @endif
                                @endforeach

                            </x-adminlte-select2>
                        </div>
                        
                        <div class="form-group">
                            <button class="btn btn-gray" type="submit">Guardar</button>
                            <a class="btn btn-gray" role="button" href="{{ route("roles.index") }}">Volver</a>
                        </div>
                    </form>

                </div>    
            </div>

        </div>
    </div>

@stop

@section('plugins.Select2', true)

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

    </script>
@stop