<div>
    <div class="row">        
    
        <x-adminlte-input-switch name="sexo" label="Sexo" enable-old-support fgroup-class="col-lg-2 col-md-4 col-sm-6" data-on-text="M" data-off-text="F" data-on-color="teal" data-off-color="pink" checked/>
    
        @php
        $config = ['format' => 'DD-MM-YYYY'];
        @endphp
        <x-adminlte-input-date name="nacimiento" label="Fecha de Nacimiento" enable-old-support fgroup-class="col-lg-2 col-md-4 col-sm-6" :config="$config"/>

        <div class="form-group col-lg-2 col-md-4 col-sm-6">
            <label for="Jefe de familia">Jefe de Familia</label>

            <div class="input-group">
                <div class="form-check">
                    <input type="checkbox" name="jefe" class="form-check-input" wire:model="jefeCheck">
                </div>
            </div>
        </div>

        @if (true)
            <div class="row">
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
                        @if ($jefeOld == $jefe->id)
                            <option selected value="{{ $jefe->id }}">{{ $jefe->datos->id }}</option>                    
                        @else
                            <option value="{{ $jefe->id }}">{{ $jefe->datos->nombres }}</option>
                        @endif
                    @endforeach
                </x-adminlte-select2>
            </div>
        @endif
    
    </div>    
    
    @push('js')
        <script>
    
            $(() => {
    
                $('#jefe').on('change', function (e) {
                    var jefe = $('#jefe').bootstrapSwitch('state')
                    console.log("cambio de switch");
                    @this.set('jefe', 'jefe')
                    Livewire.emit('jefeChange')
                });
    
            });
    
        </script>
    @endpush
</div>