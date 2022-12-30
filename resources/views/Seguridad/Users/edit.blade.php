@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Editar Usuario {{ $user->nombre }}</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-md-12">

                    <form action="{{ route("usuarios.update", $user) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <x-adminlte-input name="nombre" label="Nombre" placeholder="" enable-old-support value="{{ $user->name }}">
                                <x-slot name="bottomSlot">
                                    @error('nombre')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>
                            </x-adminlte-input>
                        </div>
                        
                        <div class="form-group">
                            <x-adminlte-input name="usuario" label="Usuario" placeholder="" enable-old-support value="{{ $user->usuario }}">
                                <x-slot name="bottomSlot">
                                    @error('usuario')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </x-slot>
                            </x-adminlte-input>
                        </div>

                        <div class="form-group">
                            <x-adminlte-select name="rol" label="Rol de Usuario" enable-old-support>
                                @foreach ($roles as $rol)
                                    @foreach ($user->roles as $userr)
                                        @if ($userr->pivot->role_id == $rol->id)
                                            <option selected value="{{ $rol->id }}">{{ $rol->name }}</option>
                                        @else
                                            <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                        @endif
                                    @endforeach
                                @endforeach
                            </x-adminlte-select>
                        </div>
                        
                        <div class="form-group">
                            <button class="btn btn-gray" type="submit">Guardar</button>
                            <a class="btn btn-gray" role="button" href="{{ route("usuarios.index") }}">Volver</a>
                        </div>
                    </form>

                </div>    
            </div>

        </div>
    </div>

@stop

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