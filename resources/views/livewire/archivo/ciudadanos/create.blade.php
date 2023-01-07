<div>
    <div class="row">
        @if ($readonly)
            <x-adminlte-input readonly name="cedula" label="C.I" placeholder="" enable-old-support wire:model="cedula" maxlength="8" fgroup-class="col-lg-6 col-md-6 col-sm-12">
                <x-slot name="appendSlot">
                    <x-adminlte-button wire:click="limpiar" label="Limpiar"/>
                </x-slot>
                <x-slot name="prependSlot">
                    <select name="nacionalidad" class="form-control">
                        @if ($nacionalidad == 'e')
                            <option value="v">V</option>                    
                            <option value="e" selected>E</option>
                        @else                
                            <option value="v" selected>V</option>                    
                            <option value="e">E</option>
                        @endif
                    </select>
                </x-slot>
                <x-slot name="bottomSlot">
                    <span class="text-danger">{{ $errorci }}</span>
                    @error('cedula')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </x-slot>
            </x-adminlte-input>
        @else
            <x-adminlte-input name="cedula" label="C.I" placeholder="" enable-old-support wire:model="cedula" maxlength="8" fgroup-class="col-lg-6 col-md-6 col-sm-12">
                <x-slot name="appendSlot">
                    <div class="input-group-text" wire:loading wire:target="buscarci">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                    <x-adminlte-button wire:click="buscarci" label="Buscar"/>                    
                </x-slot>
                <x-slot name="prependSlot">
                    <select name="nacionalidad" class="form-control">
                        @if ($nacionalidad == 'v')
                            <option value="v" selected>V</option>                    
                            <option value="e">E</option>
                        @else                
                            <option value="v">V</option>                    
                            <option value="e" selected>E</option>
                        @endif
                    </select>
                </x-slot>
                <x-slot name="bottomSlot">
                    <span class="text-danger">{{ $errorci }}</span>
                    @error('cedula')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </x-slot>
            </x-adminlte-input>
        @endif

    {{-- </div>

    <div class="form-group"> --}}

        @if ($readonly)
        <x-adminlte-input readonly name="nombres" label="Nombre" placeholder="" enable-old-support wire:model="nombre" fgroup-class="col-lg-6 col-md-6 col-sm-12">
            <x-slot name="bottomSlot">
                @error('nombres')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </x-slot>
        </x-adminlte-input>
        @else
        <x-adminlte-input name="nombres" label="Nombre" placeholder="" enable-old-support wire:model="nombre" fgroup-class="col-lg-6 col-md-6 col-sm-12">
            <x-slot name="bottomSlot">
                @error('nombres')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </x-slot>
        </x-adminlte-input>
        @endif
        
    </div>

    <div class="row">

        @if ($readonly)
        <x-adminlte-input readonly name="apellidos" label="Apellido" placeholder="" enable-old-support wire:model="apellido" fgroup-class="col-lg-6 col-md-6 col-sm-12">
            <x-slot name="bottomSlot">
                @error('apellidos')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </x-slot>
        </x-adminlte-input>
        @else
        <x-adminlte-input name="apellidos" label="Apellido" placeholder="" enable-old-support wire:model="apellido" fgroup-class="col-lg-6 col-md-6 col-sm-12">
            <x-slot name="bottomSlot">
                @error('apellidos')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </x-slot>
        </x-adminlte-input>
        @endif
        
    {{-- </div>

    <div class="form-group"> --}}
        <x-adminlte-input name="telefono" wire:model="telefono" label="Telefono" placeholder="" enable-old-support maxlength="7" fgroup-class="col-lg-6 col-md-6 col-sm-12">
            <x-slot name="prependSlot">
                <x-adminlte-select name="codigo">
                    @switch($codigo)
                        @case('0414')
                            <option value="0414" selected>0414</option>
                            <option value="0424">0424</option>
                            <option value="0412">0412</option>
                            <option value="0416">0416</option>
                            <option value="0426">0426</option>
                            @break
                        @case('0424')
                            <option value="0414">0414</option>
                            <option value="0424" selected>0424</option>
                            <option value="0412">0412</option>
                            <option value="0416">0416</option>
                            <option value="0426">0426</option>
                            @break
                        @case('0412')
                            <option value="0414">0414</option>
                            <option value="0424">0424</option>
                            <option value="0412" selected>0412</option>
                            <option value="0416">0416</option>
                            <option value="0426">0426</option>
                            @break
                        @case('0416')
                            <option value="0414">0414</option>
                            <option value="0424">0424</option>
                            <option value="0412">0412</option>
                            <option value="0416" selected>0416</option>
                            <option value="0426">0426</option>
                            @break
                        @case('0426')
                            <option value="0414">0414</option>
                            <option value="0424">0424</option>
                            <option value="0412">0412</option>
                            <option value="0416">0416</option>
                            <option value="0426" selected>0426</option>
                            @break
                        @default
                            <option value="0414">0414</option>
                            <option value="0424">0424</option>
                            <option value="0412">0412</option>
                            <option value="0416">0416</option>
                            <option value="0426">0426</option>
                    @endswitch
                </x-adminlte-select>
            </x-slot>
            <x-slot name="bottomSlot">
                @error('telefono')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </x-slot>
        </x-adminlte-input>
    </div>

</div>