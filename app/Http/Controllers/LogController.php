<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Http\Requests\StoreLogRequest;
use App\Http\Requests\UpdateLogRequest;
use App\Models\Ciudadano;
use App\Models\Comuna;
use App\Models\Concejo;
use App\Models\Infante;
use App\Models\Jefe;
use App\Models\Parroquia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log as FacadesLog;

class LogController extends Controller
{
    public function __construct() {
        $this->middleware('can:logs.index')->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = Log::with('usuario')->get();
        return view('Seguridad.Logs.index', [
            'logs' => $logs,
        ]);
    }

    public function dashboard()
    {
        $poblacion = Ciudadano::count();
        $infantes = Infante::count();
        $aumentop = Ciudadano::whereDate('created_at', '>', date('Y-m-d', strtotime('now - 1 week')))->count();
        $aumentoi = Infante::whereDate('created_at', '>', date('Y-m-d', strtotime('now - 1 week')))->count();
        $genero = Ciudadano::where('sexo', 'M')->count();
        $generoi = Infante::where('sexo', 'M')->count();
        $edadm = Ciudadano::whereDate('nacimiento', '>', date('Y-m-d', strtotime('now - 18 year')))->count();
        $abuelos = Ciudadano::whereDate('nacimiento', '<', date('Y-m-d', strtotime('now - 60 year')))->count();
        $jefesf = Jefe::count();

        $parroquias = Parroquia::count();
        $comunas = Comuna::count();
        $concejos = Concejo::count();

        $mes = date('m');
        $ano = date('Y');        

        for ($i=0; $i < 12-$mes; $i++) { 
            $result[] = 12-$i;
            switch ($mes+$i+1) {
                case 12:
                    $labelM[] = 'Dic '.$ano-1;
                    $dataQ[] = ['mes' => $mes+$i+1, 'año' => $ano-1];
                    break;
                
                case 11:
                    $labelM[] = 'Nov '.$ano-1;
                    $dataQ[] = ['mes' => $mes+$i+1, 'año' => $ano-1];
                    break;
                    
                case 10:
                    $labelM[] = 'Oct '.$ano-1;
                    $dataQ[] = ['mes' => $mes+$i+1, 'año' => $ano-1];
                    break;
                
                case 9:
                    $labelM[] = 'Sep '.$ano-1;
                    $dataQ[] = ['mes' => $mes+$i+1, 'año' => $ano-1];
                    break;
                    
                case 8:
                    $labelM[] = 'Ago '.$ano-1;
                    $dataQ[] = ['mes' => $mes+$i+1, 'año' => $ano-1];
                    break;
                
                case 7:
                    $labelM[] = 'Jul '.$ano-1;
                    $dataQ[] = ['mes' => $mes+$i+1, 'año' => $ano-1];
                    break;
                    
                case 6:
                    $labelM[] = 'Jun '.$ano-1;
                    $dataQ[] = ['mes' => $mes+$i+1, 'año' => $ano-1];
                    break;
                
                case 5:
                    $labelM[] = 'May '.$ano-1;
                    $dataQ[] = ['mes' => $mes+$i+1, 'año' => $ano-1];
                    break;
                    
                case 4:
                    $labelM[] = 'Abr '.$ano-1;
                    $dataQ[] = ['mes' => $mes+$i+1, 'año' => $ano-1];
                    break;
                    
                case 3:
                    $labelM[] = 'Mar '.$ano-1;
                    $dataQ[] = ['mes' => $mes+$i+1, 'año' => $ano-1];
                    break;
                
                case 2:
                    $labelM[] = 'Feb '.$ano-1;
                    $dataQ[] = ['mes' => $mes+$i+1, 'año' => $ano-1];
                    break;
                    
                case 1:
                    $labelM[] = 'Ene '.$ano-1;
                    $dataQ[] = ['mes' => $mes+$i+1, 'año' => $ano-1];
                    break;
            }
        }

        for ($i=0; $i < $mes; $i++) { 
            $data[] = $mes-$i;
            switch ($i+1) {
                case 12:
                    $labelM[] = 'Dic '.$ano;
                    $dataQ[] = ['mes' => $i+1, 'año' => $ano];
                    break;
                
                case 11:
                    $labelM[] = 'Nov '.$ano;
                    $dataQ[] = ['mes' => $i+1, 'año' => $ano];
                    break;
                    
                case 10:
                    $labelM[] = 'Oct '.$ano;
                    $dataQ[] = ['mes' => $i+1, 'año' => $ano];
                    break;
                
                case 9:
                    $labelM[] = 'Sep '.$ano;
                    $dataQ[] = ['mes' => $i+1, 'año' => $ano];
                    break;
                    
                case 8:
                    $labelM[] = 'Ago '.$ano;
                    $dataQ[] = ['mes' => $i+1, 'año' => $ano];
                    break;
                
                case 7:
                    $labelM[] = 'Jul '.$ano;
                    $dataQ[] = ['mes' => $i+1, 'año' => $ano];
                    break;
                    
                case 6:
                    $labelM[] = 'Jun '.$ano;
                    $dataQ[] = ['mes' => $i+1, 'año' => $ano];
                    break;
                
                case 5:
                    $labelM[] = 'May '.$ano;
                    $dataQ[] = ['mes' => $i+1, 'año' => $ano];
                    break;
                    
                case 4:
                    $labelM[] = 'Abr '.$ano;
                    $dataQ[] = ['mes' => $i+1, 'año' => $ano];
                    break;
                    
                case 3:
                    $labelM[] = 'Mar '.$ano;
                    $dataQ[] = ['mes' => $i+1, 'año' => $ano];
                    break;
                
                case 2:
                    $labelM[] = 'Feb '.$ano;
                    $dataQ[] = ['mes' => $i+1, 'año' => $ano];
                    break;
                    
                case 1:
                    $labelM[] = 'Ene '.$ano;
                    $dataQ[] = ['mes' => $i+1, 'año' => $ano];
                    break;
            }
        }
        
        foreach ($dataQ as $key => $value) {
            $ciudadanosG = Ciudadano::whereMonth('created_at', $value['mes'])->whereYear('created_at', $value['año'])->count();
            $infantesG = Infante::whereMonth('created_at', $value['mes'])->whereYear('created_at', $value['año'])->count();

            $poblacionG[] = $ciudadanosG+$infantesG;
        }
        
        return view('dashboard', [
            'poblacion' => $poblacion+$infantes,
            'aumentop' => $aumentop+$aumentoi,
            'genero' => $genero+$generoi,
            'edadm' => $edadm+$infantes,
            'abuelos' => $abuelos,
            'parroquias' => $parroquias,
            'comunas' => $comunas,
            'concejos' => $concejos,
            'labelm' => $labelM,
            'poblaciong' => $poblacionG,
            'jefesf' => $jefesf,
        ]);
    }

    public function notifications()
    {
        $dropdownHtml = '';

        
        foreach (Auth::user()->unreadNotifications as $notification) {

            switch ($notification->data['data']) {
                case 'Ciudadanos':
                    if ($notification->data['type'] == 'CSV') {
                        $ruta = route('ciudadanos.csv', [
                            'notification' => $notification->id
                        ]);
                        $dropdownHtml .= "<a href='".$ruta."' class='dropdown-item'>Exportacion de ciudadanos en CSV.<span class='float-right text-muted text-sm'>Haz clic para descargar</span></a>";                        
                    } else {
                        $ruta = route('ciudadanos.excel', [
                            'notification' => $notification->id
                        ]);
                        $dropdownHtml .= "<a href='".$ruta."' class='dropdown-item'>Exportacion de ciudadanos en Excel.<span class='float-right text-muted text-sm'>Haz clic para descargar</span></a>";
                    }                    
                    break;
                    
                case 'Infantes':
                    if ($notification->data['type'] == 'CSV') {
                        $ruta = route('infantes.csv', [
                            'notification' => $notification->id
                        ]);
                        $dropdownHtml .= "<a href='".$ruta."' class='dropdown-item'>Exportacion de infantes en CSV.<span class='float-right text-muted text-sm'>Haz clic para descargar</span></a>";                        
                    } else {
                        $ruta = route('infantes.excel', [
                            'notification' => $notification->id
                        ]);
                        $dropdownHtml .= "<a href='".$ruta."' class='dropdown-item'>Exportacion de infantes en Excel.<span class='float-right text-muted text-sm'>Haz clic para descargar</span></a>";
                    }
                    break;
            }

        }
        /* $notifications = [
            [
                'icon' => 'fas fa-fw fa-envelope',
                'text' => rand(0, 10) . ' new messages',
                'time' => rand(0, 10) . ' minutes',
            ],
            [
                'icon' => 'fas fa-fw fa-users text-primary',
                'text' => rand(0, 10) . ' friend requests',
                'time' => rand(0, 60) . ' minutes',
            ],
            [
                'icon' => 'fas fa-fw fa-file text-danger',
                'text' => rand(0, 10) . ' new reports',
                'time' => rand(0, 60) . ' minutes',
            ],
        ]; */
    
        // Now, we create the notification dropdown main content.
    
        /* $dropdownHtml = '';
    
        foreach ($notifications as $notification) {
            $dropdownHtml .= "<a href='#' class='dropdown-item'>".$notification->type."</a>";
            /* $icon = "<i class='mr-2 {$not['icon']}'></i>";
    
            $time = "<span class='float-right text-muted text-sm'>
                       {$not['time']}
                     </span>";
    
            $dropdownHtml .= "<a href='#' class='dropdown-item'>
                                {$icon}{$not['text']}{$time}
                              </a>";
    
            if ($key < count($notifications) - 1) {
                $dropdownHtml .= "<div class='dropdown-divider'></div>";
            } 
        } */
    
        // Return the new notification data.
    
        return [
            'label'       => Auth::user()->unreadNotifications->count(),
            'label_color' => 'danger',
            'icon_color'  => 'dark',
            'dropdown'    => $dropdownHtml,
        ];
    }

}
