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
                            <option value="nacimiento">F. Nacimiento</option>
                            <option value="concejo">Representante</option>
                        </select>
                    </div>

                    <input type="text" class="form-control" placeholder="Buscar..." wire:model="search">
                </div>
            </div>
        </div>        
    </div>
    
    @if ($infantes->count())
    <div class="card-body">            
        
        <table id="ciudadanos-table" class="table table-hover responsive">
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>F. de Nacimiento</th>
                    <th>Representante</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($infantes as $infante)
                    <tr>
                        <td>{{ $infante->nombre }}</td>
                        <td>{{ $infante->apellido }}</td>
                        <td>{{ $infante->nacimiento }}</td>
                        <td>{{ $infante->ciudadano->nombres }} {{ $infante->ciudadano->apellidos }}</td>
                        <td>
                            @can('personas.index')
                                <a href="{{ route('infantes.show', $infante) }}" target="blank" title="Ver Detalles" class="btn btn-sm btn-secondary mx-1 shadow">
                                    <i class="fa fa-clipboard-list"></i>
                                </a>
                            @endcan
                            
                            @can('personas.edit')
                                <a href="{{ route('infantes.edit', $infante) }}" title="Editar" class="btn btn-sm btn-secondary mx-1 shadow">
                                    <i class="fa fa-fw fa-edit"></i>
                                </a>
                            @endcan

                            @can('personas.destroy')
                                <button title="Eliminar" class="btn btn-sm btn-secondary mx-1 shadow" onclick="event.preventDefault();
                                document.getElementById({{$infante->id}}).submit();">
                                    <i class="fa fw fa-trash"></i>
                                </button>

                                <form action="{{ route('infantes.destroy', $infante) }}" method="POST" id="{{$infante->id}}" class="d-none">
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
                {{ $infantes->links() }}
            </div>
            
            <div class="col-md-6">

            </div>
        </div>
    </div>
    @else
        <div class="card-body">
            <strong>No existe ningun infante.</strong>
        </div>
    @endif
    
</div>
