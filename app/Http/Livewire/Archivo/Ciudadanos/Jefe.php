<?php

namespace App\Http\Livewire\Archivo\Ciudadanos;

use App\Models\Ciudadano;
use App\Models\Jefe as ModelsJefe;
use Livewire\Component;

class Jefe extends Component
{
    public $jefes;
    public $jefeCheck = false;
    public $jefeOld = null;
    public $ciudadanos;

    protected $listeners = [
        'jefeChanged' => 'jefeChanged',
        'jefChanged' => 'jefChanged',
    ];

    public function mount()
    {
        $this->jefes = ModelsJefe::with('datos')->get();
        $this->ciudadanos = Ciudadano::doesntHave('jefe')->get();
    }

    public function jefeChange()
    {
        if ($this->jefeCheck) {
            $this->dispatchBrowserEvent('jefChanged');
        } else {
            $this->dispatchBrowserEvent('jefeChanged');
        }
        
    }

    public function render()
    {
        return view('livewire.archivo.ciudadanos.jefe');
    }
}
