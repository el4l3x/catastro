<?php

namespace App\Http\Livewire\Archivo\Ciudadanos;

use App\Models\Jefe as ModelsJefe;
use Livewire\Component;

class Jefe extends Component
{
    public $jefes;
    public $jefeCheck = false;
    public $jefeOld = null;

    public function mount()
    {
        /* $this->jefes = ModelsJefe::with('datos')->get(); */
    }

    public function render()
    {
        return view('livewire.archivo.ciudadanos.jefe');
    }
}
