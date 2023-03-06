<?php

namespace App\Listener;

use App\Events\ExportCiudadanosExcel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DownloadExcelCiudadanos
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ExportCiudadanosExcel  $event
     * @return void
     */
    public function handle(ExportCiudadanosExcel $event)
    {
        Storage::download('ciudadanos.xlsx');
        Log::info('EVENTO EXCEL');
    }
}
