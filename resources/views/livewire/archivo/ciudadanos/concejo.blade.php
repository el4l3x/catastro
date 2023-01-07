<div>
    <div class="row" wire:ignore>
        @php
        $configu = [
            "placeholder" => "",
            "allowClear" => false,
            "liveSearch" => true,
            "liveSearchPlaceholder" => "Buscar...",
            "title" => "Selecciona la comuna...",
            "showTick" => false,
            "actionsBox" => false,
        ];
        @endphp
        <x-adminlte-select2 id="comuna" name="comuna" label="Comuna" :config="$configu" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12">
            @foreach ($comunas as $comuna)
                @if ($comunaOld == $comuna->id)
                    <option selected value="{{ $comuna->id }}">{{ $comuna->nombre }}</option>
                @else
                    <option value="{{ $comuna->id }}">{{ $comuna->nombre }}</option>
                @endif
            @endforeach
        </x-adminlte-select2>        
        
    </div>

    <div class="row">
        @php
        $configu = [
            "placeholder" => "",
            "allowClear" => false,
            "liveSearch" => true,
            "liveSearchPlaceholder" => "Buscar...",
            "title" => "Selecciona el Concejo Comunal...",
            "showTick" => false,
            "actionsBox" => false,
        ];
        @endphp
        <x-adminlte-select2 id="concejo" name="concejo" label="Concejo Comunal" :config="$configu" enable-old-support fgroup-class="col-lg-6 col-md-6 col-sm-12">
            @foreach ($concejos as $concejo)
                @if ($concejoOld == $concejo->id)
                    <option selected value="{{ $concejo->id }}">{{ $concejo->nombre }}</option>                    
                @else
                    <option value="{{ $concejo->id }}">{{ $concejo->nombre }}</option>
                @endif
            @endforeach
        </x-adminlte-select2>
    </div>
    
    @push('js')
        <script>
    
            $(() => {
    
                $('#comuna').on('change', function (e) {
                    var comunaId = $('#comuna').select2("val")
                    @this.set('comunaSelected', comunaId)
                    Livewire.emit('comunaChange')
                });
    
            });

            window.addEventListener('contentChanged', event => {
                $('#concejo').select2('destroy');
                $('#concejo').select2();
            });
    
        </script>
    @endpush
</div>