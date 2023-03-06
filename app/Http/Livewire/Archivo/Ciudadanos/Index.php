<?php

namespace App\Http\Livewire\Archivo\Ciudadanos;

use App\Jobs\CsvCiudadanos;
use App\Jobs\ExcelCiudadanos;
use App\Models\Ciudadano;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";

    public $search;
    public $filter;
    public $batchId;
    public $batchIdCsv;
    public $exporting = false;
    public $exportFinished = false;
    public $exportingCsv = false;
    public $exportFinishedCsv = false;
    public $breed = 1;

    public function export()
    {
        $this->exporting = true;
        $this->exportFinished = false;

        $batch = Bus::batch([
            new ExcelCiudadanos($this->filter, $this->search, Auth::user()),
        ])->dispatch();

        $this->batchId = $batch->id;
    }
    
    public function exportCsv()
    {
        $this->exportingCsv = true;
        $this->exportFinishedCsv = false;

        $batch = Bus::batch([
            new CsvCiudadanos($this->filter, $this->search, Auth::user()),
        ])->dispatch();

        $this->batchIdCsv = $batch->id;
    }

    public function getExportBatchProperty()
    {
        if (!$this->batchId) {
            return null;
        }

        return Bus::findBatch($this->batchId);
    }
    
    public function getExportBatchCsvProperty()
    {
        if (!$this->batchIdCsv) {
            return null;
        }

        return Bus::findBatch($this->batchIdCsv);
    }

    public function downloadExport()
    {
        return Storage::download('ciudadanos.xlsx');
    }

    public function updateExportProgress()
    {
        $this->exportFinished = $this->exportBatch->finished();

        if ($this->exportFinished) {
            $this->exporting = false;
        }
    }
    
    public function updateExportProgressCsv()
    {
        $this->exportFinishedCsv = $this->exportBatchCsv->finished();

        if ($this->exportFinishedCsv) {
            $this->exportingCsv = false;
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        switch ($this->filter) {
            case 'nombre':
                $ciudadanos = Ciudadano::with('concejo.comuna', 'parroquia')
                        ->Where('nombres', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('apellidos', 'LIKE', '%'.$this->search.'%')
                        ->paginate(10);
                break;
                
            case 'cedula':
                $ciudadanos = Ciudadano::with('concejo.comuna', 'parroquia')
                        ->Where('cedula', 'LIKE', '%'.$this->search.'%')
                        ->paginate(10);
                break;
                
            case 'nacimiento':
                $ciudadanos = Ciudadano::with('concejo.comuna', 'parroquia')
                        ->Where('nacimiento', 'LIKE', '%'.$this->search.'%')
                        ->paginate(10);
                break;
                
            case 'concejo':
                $ciudadanos = Ciudadano::withWhereHas('concejo', function ($query)
                {
                    $query->where('nombre', 'LIKE', '%'.$this->search.'%');
                })->paginate(10);
                break;
                
            case 'comuna':
                $ciudadanos = Ciudadano::withWhereHas('concejo.comuna', function ($query)
                {
                    $query->where('nombre', 'LIKE', '%'.$this->search.'%');
                })->paginate(10);
                break;
                
            case 'parroquia':
                $ciudadanos = Ciudadano::withWhereHas('parroquia', function ($query)
                {
                    $query->where('nombre', 'LIKE', '%'.$this->search.'%');
                })->paginate(10);
                break;
            
            default:
                $ciudadanos = Ciudadano::with('concejo.comuna', 'parroquia')
                    ->where('nombres', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('apellidos', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('cedula', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('nacimiento', 'LIKE', '%'.$this->search.'%')
                    ->orWhereHas('concejo', function (Builder $query)
                    {
                        $query->where('nombre', 'LIKE', '%'.$this->search.'%');
                    })->orWhereHas('concejo.comuna', function (Builder $query)
                    {
                        $query->where('nombre', 'LIKE', '%'.$this->search.'%');
                    })->orWhereHas('parroquia', function (Builder $query)
                    {
                        $query->where('nombre', 'LIKE', '%'.$this->search.'%');
                    })->paginate(10);
                break;
        }        

        return view('livewire.archivo.ciudadanos.index', [
            'ciudadanos' => $ciudadanos,
        ]);
    }
}
