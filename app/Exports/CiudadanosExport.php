<?php

namespace App\Exports;

use App\Models\Ciudadano;
use App\Models\Infante;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CiudadanosExport implements FromQuery
{
    use Exportable;

    public function query()
    {
        /* return Infante::query(); */
        return Ciudadano::query();
    }

}
