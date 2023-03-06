<?php

namespace App\Providers;

use App\Events\ExportCiudadanosExcel;
use App\Models\User;
use App\Notifications\DownloadCiudadanos;
use Illuminate\Pagination\Paginator;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFour();

        Queue::after(function (JobProcessed $event) {

            if ($event->connectionName === 'database' && $event->job->resolveName() === 'App\Jobs\ExcelCiudadanos') {                
                FacadesLog::info('EXPORTACION EXCEL');
                /* $data = [
                    'type' => 'excel',
                    'user_id' => Auth::user()->id,
                ];

                Auth::user()->notify(new DownloadCiudadanos($data)); */
                /* Notification::send(Auth::user(), new DownloadCiudadanos($data)); */

                FacadesLog::info('NOTIFICACION EXPORTACION EXCEL');

                /* ExportCiudadanosExcel::dispatch('excel'); */
                /* $data = [
                    'model' => 'Ciudadanos',
                    'type'  => 'Excel',
                ];
                Notification::send($data); */
            }

        });
    }
}
