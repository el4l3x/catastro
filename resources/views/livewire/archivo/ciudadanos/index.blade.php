<div class="card">
    
    <div class="card-header">
        <div class="row">

            <div class="col-md-6">
                <a wire:click="export" class="btn btn-outline-primary">
                    @if ($exporting && !$exportFinished)
                        <span wire:poll="updateExportProgress">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                    @else
                        Excel                        
                    @endif
                </a>
            
            
                @if($exportFinished)
                    Hecho. Descargar archivo <a class="d-inline" wire:click="downloadExport">aqui</a>
                @endif
                
                <a wire:click="exportCsv" class="btn btn-outline-primary">
                    @if ($exportingCsv && !$exportFinishedCsv)
                        <span wire:poll="updateExportProgressCsv">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                    @else
                        CSV
                    @endif
                </a>
            
            
                @if($exportFinishedCsv)
                    Hecho. Descargar archivo <a class="d-inline" wire:click="downloadExportCSV">aqui</a>
                @endif
            </div>
            
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <select name="filter" id="filter" class="custom-select" wire:model="filter">
                            <option disabled selected>Selecciona un filtro...</option>
                            <option value="null">Desactivado</option>
                            <option value="nombre">Nombre o Apellido</option>
                            <option value="cedula">Cedula</option>
                            <option value="nacimiento">F. Nacimiento</option>
                            <option value="concejo">C. Comunal</option>
                            <option value="comuna">Comuna</option>
                            <option value="parroquia">Parroquia</option>
                        </select>
                    </div>

                    <input type="text" class="form-control" placeholder="Buscar..." wire:model="search">
                </div>
            </div>
        </div>        
    </div>
    
    @if ($ciudadanos->count())
    <div class="card-body">            
        
        <table id="ciudadanos-table" class="table table-hover responsive">
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Cedula</th>
                    <th>F. de Nacimiento</th>
                    <th>C. Comunal</th>
                    <th>Comuna</th>
                    <th>Parroquia</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ciudadanos as $ciudadano)
                    <tr>
                        <td>{{ $ciudadano->nombres }}</td>
                        <td>{{ $ciudadano->apellidos }}</td>
                        <td>{{ $ciudadano->nacionalidad }}-{{$ciudadano->cedula}}</td>
                        <td>{{ $ciudadano->nacimiento }}</td>
                        <td>{{ $ciudadano->concejo->nombre }}</td>
                        <td>{{ $ciudadano->concejo->comuna->nombre }}</td>
                        <td>{{ $ciudadano->parroquia->nombre }}</td>
                        <td>
                            @can('personas.index')
                                <a href="{{ route('ciudadanos.show', $ciudadano) }}" target="blank" title="Ver Detalles" class="btn btn-sm btn-secondary mx-1 shadow">
                                    <i class="fa fa-clipboard-list"></i>
                                </a>
                            @endcan
                            
                            @can('personas.edit')
                                <a href="{{ route('ciudadanos.edit', $ciudadano) }}" title="Editar" class="btn btn-sm btn-secondary mx-1 shadow">
                                    <i class="fa fa-fw fa-edit"></i>
                                </a>
                            @endcan

                            @can('personas.destroy')
                                <button title="Eliminar" class="btn btn-sm btn-secondary mx-1 shadow" onclick="event.preventDefault();
                                document.getElementById({{$ciudadano->id}}).submit();">
                                    <i class="fa fw fa-trash"></i>
                                </button>

                                <form action="{{ route('ciudadanos.destroy', $ciudadano) }}" method="POST" id="{{$ciudadano->id}}" class="d-none">
                                    @csrf
                                    @method('delete')
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="card-footer">
        <div class="row justify-content-end mb-3">
            <div class="col-md-6">
                {{ $ciudadanos->links() }}
            </div>
            
            <div class="col-md-6">

            </div>
        </div>
    </div>
    @else
        <div class="card-body">
            <strong>No existe ningun ciudadano.</strong>
        </div>
    @endif
    
</div>
