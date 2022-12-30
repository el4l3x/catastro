<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Http\Requests\StoreLogRequest;
use App\Http\Requests\UpdateLogRequest;

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

}
