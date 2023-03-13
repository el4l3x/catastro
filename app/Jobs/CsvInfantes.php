<?php

namespace App\Jobs;

use App\Models\Infante;
use App\Models\User;
use App\Notifications\Export;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;

class CsvInfantes implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $filter;
    public $search;
    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filter = null, $search = null, User $user)
    {
        $this->filter = $filter;
        $this->search = $search;
        $this->user = $user;
    }

    protected function infantesGenerator()
    {
        $ciudadanos = Infante::query();

        $chunks_per_loop = 2000;
        $ciudadano_count = (clone $ciudadanos)->count();
        $chunks = (int) ceil(($ciudadano_count / $chunks_per_loop));

        for ($i = 0; $i < $chunks; $i++) {
            switch ($this->filter) {
                case 'nombre':
                    $clonedCiudadanos = (clone $ciudadanos)->where('nombre', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('apellido', 'LIKE', '%'.$this->search.'%')
                        ->with('ciudadano')
                        ->skip($i * $chunks_per_loop)
                        ->take($chunks_per_loop)
                        ->cursor();
                    break;

                case 'nacimiento':
                    $clonedCiudadanos = (clone $ciudadanos)->where('nacimiento', 'LIKE', '%'.$this->search.'%')
                        ->with('ciudadano')
                        ->skip($i * $chunks_per_loop)
                        ->take($chunks_per_loop)
                        ->cursor();
                    break;
                    
                case 'representante':
                    $clonedCiudadanos = (clone $ciudadanos)->withWhereHas('ciudadano', function ($query)
                        {
                            $query->where('nombres', 'LIKE', '%'.$this->search.'%')->orWhere('apellidos', 'LIKE', '%'.$this->search.'%');
                        })->skip($i * $chunks_per_loop)
                        ->take($chunks_per_loop)
                        ->cursor();
                    break;
                
                default:
                    $clonedCiudadanos = (clone $ciudadanos)->with('ciudadano')->skip($i * $chunks_per_loop)
                        ->take($chunks_per_loop)
                        ->cursor();
                    break;
            }

            foreach ($clonedCiudadanos as $ciudadano) {
                yield $ciudadano;
            }
        }

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $filename = 'storage/app/public/infantes.csv';      

            (new FastExcel($this->infantesGenerator()))->export($filename, function ($ciudadano)
            {
                return [
                    "Nombres" => $ciudadano->nombre,
                    "Apellidos" => $ciudadano->apellido,
                    "F. de Nacimiento" => $ciudadano->nacimiento,
                    "Representante" => $ciudadano->ciudadano->nombres." ".$ciudadano->ciudadano->apellidos,
                ];
            });

            $data = [
                'type'  => 'CSV',
                'data'  => 'Infantes',
            ];

            $this->user->notify(new Export($data));
        } catch (\Throwable $th) {
            Log::error('ERROR EN EXPORTACION O NOTIFICACION');
            Log::debug($th);
        }
    }
}
