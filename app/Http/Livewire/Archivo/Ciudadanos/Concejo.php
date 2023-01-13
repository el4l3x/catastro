<?php

namespace App\Http\Livewire\Archivo\Ciudadanos;

use App\Models\Comuna;
use App\Models\Concejo as ModelsConcejo;
use Livewire\Component;

class Concejo extends Component
{
    public $comunas;
    public $concejos;
    public $comunaSelected;
    public $comunaOld = null;
    public $concejoOld = null;

    protected $listeners = ['comunaChange' => 'comunaChange'];

    public function mount()
    {
        $this->comunas = Comuna::with('concejos')->get();
        $comuna = Comuna::with('concejos')->first();
        if ($this->comunaOld != null) {
            $this->concejos = ModelsConcejo::where('comuna_id', $this->comunaOld)->get();   
        } else {
            $this->concejos = ModelsConcejo::where('comuna_id', $comuna->id)->get();
        }
    }

    public function comunaChange()
    {
        $this->concejos = ModelsConcejo::where('comuna_id', $this->comunaSelected)->get();
        $this->dispatchBrowserEvent('contentChanged');
    }
    
    public function render()
    {
        if ($this->comunaOld != null) {
            return view('livewire.archivo.ciudadanos.concejo', [
                'comunaOld' => $this->comunaOld,
                'concejoOld' => $this->concejoOld,
            ]);
        } else {
            return view('livewire.archivo.ciudadanos.concejo');
        }
        
    }
}
