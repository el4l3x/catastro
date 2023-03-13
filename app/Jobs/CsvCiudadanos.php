<?php

namespace App\Jobs;

use App\Models\Ciudadano;
use App\Models\User;
use App\Notifications\Export;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Rap2hpoutre\FastExcel\FastExcel;

class CsvCiudadanos implements ShouldQueue
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

    protected function ciudadanosGenerator()
    {
        $ciudadanos = Ciudadano::query();

        $chunks_per_loop = 2000;
        $ciudadano_count = (clone $ciudadanos)->count();
        $chunks = (int) ceil(($ciudadano_count / $chunks_per_loop));

        for ($i = 0; $i < $chunks; $i++) {
            switch ($this->filter) {
                case 'nombre':
                    $clonedCiudadanos = (clone $ciudadanos)->where('nombres', 'LIKE', '%'.$this->search.'%')
                        ->orWhere('apellidos', 'LIKE', '%'.$this->search.'%')
                        ->with('concejo.comuna', 'parroquia')
                        ->skip($i * $chunks_per_loop)
                        ->take($chunks_per_loop)
                        ->cursor();
                    break;

                case 'cedula':
                    $clonedCiudadanos = (clone $ciudadanos)->where('cedula', 'LIKE', '%'.$this->search.'%')->with('concejo.comuna', 'parroquia')->skip($i * $chunks_per_loop)
                        ->take($chunks_per_loop)
                        ->cursor();
                    break;

                case 'nacimiento':
                    $clonedCiudadanos = (clone $ciudadanos)->where('nacimiento', 'LIKE', '%'.$this->search.'%')
                        ->with('concejo.comuna', 'parroquia')
                        ->skip($i * $chunks_per_loop)
                        ->take($chunks_per_loop)
                        ->cursor();
                    break;
                    
                case 'concejo':
                    $clonedCiudadanos = (clone $ciudadanos)->withWhereHas('concejo', function ($query)
                        {
                            $query->where('nombre', 'LIKE', '%'.$this->search.'%');
                        })->skip($i * $chunks_per_loop)
                        ->take($chunks_per_loop)
                        ->cursor();
                    break;
                    
                case 'comuna':
                    $clonedCiudadanos = (clone $ciudadanos)->withWhereHas('concejo.comuna', function ($query)
                        {
                            $query->where('nombre', 'LIKE', '%'.$this->search.'%');
                        })->skip($i * $chunks_per_loop)
                        ->take($chunks_per_loop)
                        ->cursor();
                    break;
                    
                case 'parroquia':
                    $clonedCiudadanos = (clone $ciudadanos)->withWhereHas('parroquia', function ($query)
                        {
                            $query->where('nombre', 'LIKE', '%'.$this->search.'%');
                        })->skip($i * $chunks_per_loop)
                        ->take($chunks_per_loop)
                        ->cursor();
                    break;
                
                default:
                    $clonedCiudadanos = (clone $ciudadanos)->with('concejo.comuna', 'parroquia')->skip($i * $chunks_per_loop)
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
        $filename = '../storage/app/public/ciudadanos.csv';

        /* $infantes = Infante::all();

        (new FastExcel($infantes))->export($filename); */        

        (new FastExcel($this->ciudadanosGenerator()))->export($filename, function ($ciudadano)
        {
            return [
                "Nombres" => $ciudadano->nombres ,
                "Apellidos" => $ciudadano->apellidos ,
                "Cedula" => $ciudadano->nacionalidad."-".$ciudadano->cedula,
                "F. de Nacimiento" => $ciudadano->nacimiento ,
                "Telefono" => $ciudadano->codigo.' '.$ciudadano->telefono,
                "C. Comunal" => $ciudadano->concejo->nombre ,
                "Comuna" => $ciudadano->concejo->comuna->nombre ,
                "Parroquia" => $ciudadano->parroquia->nombre ,
            ];
        });

        $data = [
            'type'  => 'CSV',
            'data'  => 'Ciudadanos',
        ];

        $this->user->notify(new Export($data));
    }
}
