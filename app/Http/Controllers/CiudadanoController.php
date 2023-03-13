<?php

namespace App\Http\Controllers;

use App\Exports\CiudadanosExport;
use App\Models\Ciudadano;
use App\Http\Requests\StoreCiudadanoRequest;
use App\Http\Requests\UpdateCiudadanoRequest;
use App\Models\Infante;
use App\Models\Jefe;
use App\Models\Log;
use App\Models\Parroquia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use OpenSpout\Common\Entity\Style\Style;
use Rap2hpoutre\FastExcel\FastExcel;

class CiudadanoController extends Controller
{
    public function __construct() {
        $this->middleware('can:personas.index')->only('index', 'show', 'excel');
        $this->middleware('can:personas.create')->only('create', 'store');
        $this->middleware('can:personas.edit')->only('edit', 'update');
        $this->middleware('can:personas.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Archivo.Ciudadanos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parroquias = Parroquia::get();
        $jefes = Jefe::get();    

        return view('Archivo.Ciudadanos.create', [
            'parroquias' => $parroquias,
            'jefes' => $jefes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCiudadanoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCiudadanoRequest $request)
    {
        try {
            DB::beginTransaction();

            $ciudadano = new Ciudadano();
            $ciudadano->nombres = $request->nombres;
            $ciudadano->apellidos = $request->apellidos;
            $ciudadano->nacionalidad = $request->nacionalidad;
            $ciudadano->cedula = $request->cedula;
            $ciudadano->slug = Str::slug($request->cedula);
            if ($request->sexo) {
                $ciudadano->sexo = 'M';
            } else {
                $ciudadano->sexo = 'F';
            }
            $ciudadano->nacimiento = date('Y-m-d', strtotime($request->nacimiento));
            $ciudadano->codigo = $request->codigo;
            $ciudadano->telefono = $request->telefono;
            $ciudadano->direccion = $request->direccion;
            $ciudadano->concejo_id = $request->concejo;
            $ciudadano->parroquia_id = $request->parroquia;
            $ciudadano->save();

            $log = new Log();
            $log->accion = "Nuevo Ciudadano ".$ciudadano->nombres." ".$ciudadano->apellidos." (".$ciudadano->id.")";
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('ciudadanos.index');
            
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ciudadano  $ciudadano
     * @return \Illuminate\Http\Response
     */
    public function show(Ciudadano $ciudadano)
    {
        if ($ciudadano->familia->count() > 0) {
            $jefe = Jefe::find($ciudadano->familia[0]->pivot->jefe_id);
        } else {
            $jefe = NULL;
        }        
        return view('Archivo.Ciudadanos.show', [
            'ciudadano' => $ciudadano,
            'jefe' => $jefe,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ciudadano  $ciudadano
     * @return \Illuminate\Http\Response
     */
    public function edit(Ciudadano $ciudadano)
    {
        $parroquias = Parroquia::get();

        return view('Archivo.Ciudadanos.edit', [
            'ciudadano' => $ciudadano,
            'parroquias' => $parroquias,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCiudadanoRequest  $request
     * @param  \App\Models\Ciudadano  $ciudadano
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCiudadanoRequest $request, Ciudadano $ciudadano)
    {
        try {
            DB::beginTransaction();
            $ciudadano->nombres = $request->nombres;
            $ciudadano->apellidos = $request->apellidos;
            $ciudadano->nacionalidad = $request->nacionalidad;
            $ciudadano->cedula = $request->cedula;
            $ciudadano->slug = Str::slug($request->cedula);
            if ($request->sexo) {
                $ciudadano->sexo = 'M';
            } else {
                $ciudadano->sexo = 'F';
            }
            $ciudadano->nacimiento = date('Y-m-d', strtotime($request->nacimiento));
            $ciudadano->codigo = $request->codigo;
            $ciudadano->telefono = $request->telefono;
            $ciudadano->direccion = $request->direccion;
            $ciudadano->concejo_id = $request->concejo;
            $ciudadano->parroquia_id = $request->parroquia;
            $ciudadano->save();

            $log = new Log();
            $log->accion = "Editar Ciudadano ".$ciudadano->nombres." ".$ciudadano->apellidos." (".$ciudadano->id.")";
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('ciudadanos.index');
            
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ciudadano  $ciudadano
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ciudadano $ciudadano)
    {
        try {
            DB::beginTransaction();

            $ciudadano->delete();

            $log = new Log();
            $log->accion = "Eliminar Ciudadano ".$ciudadano->nombres." ".$ciudadano->apellidos." (".$ciudadano->id.")";
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('ciudadanos.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function export(Request $request)
    {
        foreach (Auth::user()->unreadNotifications as $key => $value) {
            if ($value->id == $request->notification) {
                $value->markAsRead();
            }
        }

        return response()->download(public_path('storage/ciudadanos.xlsx'));
    }
    
    public function csv(Request $request)
    {
        foreach (Auth::user()->unreadNotifications as $key => $value) {
            if ($value->id == $request->notification) {
                $value->markAsRead();
            }
        }

        return response()->download(public_path('storage/ciudadanos.csv'));
    }
}
