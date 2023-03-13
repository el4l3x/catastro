<?php

namespace App\Http\Livewire\Archivo\Infantes;

use App\Jobs\CsvInfantes;
use App\Jobs\ExcelInfantes;
use App\Models\Infante;
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
            new ExcelInfantes($this->filter, $this->search, Auth::user()),
        ])->dispatch();

        $this->batchId = $batch->id;
    }
    
    public function exportCsv()
    {
        $this->exportingCsv = true;
        $this->exportFinishedCsv = false;

        $batch = Bus::batch([
            new CsvInfantes($this->filter, $this->search, Auth::user()),
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
        return Storage::download('infantes.xlsx');
    }
    
    public function downloadExportCSV()
    {
        return Storage::download('infantes.csv');
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
                $infantes = Infante::with('ciudadano')
                        ->Where('nombre', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('apellido', 'LIKE', '%'.$this->search.'%')
                        ->paginate(10);
                break;
                
            case 'nacimiento':
                $infantes = Infante::with('ciudadano')
                        ->Where('nacimiento', 'LIKE', '%'.$this->search.'%')
                        ->paginate(10);
                break;
                
            case 'representante':
                $infantes = Infante::withWhereHas('ciudadano', function ($query)
                {
                    $query->where('nombres', 'LIKE', '%'.$this->search.'%')->orWhere('apellidos', 'LIKE', '%'.$this->search.'%');
                })->paginate(10);
                break;
            
            default:
                $infantes = Infante::with('ciudadano')
                    ->where('nombre', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('apellido', 'LIKE', '%'.$this->search.'%')
                    ->orWhereHas('ciudadano', function (Builder $query)
                    {
                        $query->where('nombres', 'LIKE', '%'.$this->search.'%')->orWhere('apellidos', 'LIKE', '%'.$this->search.'%');
                    })->paginate(10);
                break;
        }        

        return view('livewire.archivo.infantes.index', [
            'infantes' => $infantes,
        ]);
    }

}
