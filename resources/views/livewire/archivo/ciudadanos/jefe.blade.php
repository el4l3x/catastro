<div>
    <div class="row mb-3">                

        <div class="form-group col-lg-2 col-md-4 col-sm-6">
            <label for="Jefe de familia">Jefe de Familia</label>

            <div class="input-group">
                <div class="form-check">
                    <input type="checkbox" name="jefe" id="jefe" class="form-check-input" wire:model="jefeCheck" wire:change="jefeChange">
                </div>
            </div>
        </div>

        {{-- @if (!$jefeCheck) --}}
            @php
            $configu = [
                "placeholder" => "",
                "allowClear" => false,
                "liveSearch" => true,
                "liveSearchPlaceholder" => "Buscar...",
                "title" => "Selecciona el Jefe de Familia...",
                "showTick" => false,
                "actionsBox" => false,
            ];
            @endphp
            <x-adminlte-select2 id="jfamilia" name="jfamilia" label="Jefe de Familia" :config="$configu" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12">
                @foreach ($jefes as $jefe)
                    @if ($jefeOld == $jefe->datos->id)
                        <option selected value="{{ $jefe->datos->id }}">{{ $jefe->datos->nacionalidad }}-{{ $jefe->datos->cedula }} {{ $jefe->datos->nombres }} {{ $jefe->datos->apellidos }}</option>                    
                    @else
                        <option value="{{ $jefe->datos->id }}">{{ $jefe->datos->nacionalidad }}-{{ $jefe->datos->cedula }} {{ $jefe->datos->nombres }} {{ $jefe->datos->apellidos }}</option>
                    @endif
                @endforeach
            </x-adminlte-select2>

        {{-- @else --}}

            @php
            $configu = [
                "placeholder" => "",
                "allowClear" => false,
                "liveSearch" => true,
                "liveSearchPlaceholder" => "Buscar...",
                "title" => "Selecciona a la Familia...",
                "showTick" => false,
                "actionsBox" => false,
            ];
            @endphp
            <x-adminlte-select2 id="mfamilia" name="familia" label="Miembros de la Familia" :config="$configu" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12">
                @foreach ($ciudadanos as $ciudadano)
                    <option value="{{ $ciudadano->id }}">{{ $ciudadano->nacionalidad }}-{{ $ciudadano->cedula }}</option>
                @endforeach
            </x-adminlte-select2>
        {{-- @endif --}}
    
    </div>    
    
    @push('js')
        <script>
            window.addEventListener('jefeChanged', event => {
                $('#jfamilia').select2('destroy');
                $('#jfamilia').select2();
            });
            
            /* window.addEventListener('jefChanged', event => {
                $('#mfamilia').select2('destroy');
                $('#mfamilia').select2();
            }); */
        </script>
    @endpush
</div>