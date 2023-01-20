<?php

namespace App\Http\Controllers;

use App\Models\Infante;
use App\Http\Requests\StoreInfanteRequest;
use App\Http\Requests\UpdateInfanteRequest;
use App\Models\Ciudadano;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InfanteController extends Controller
{
    public function __construct() {
        $this->middleware('can:personas.index')->only('index',);
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
        $infantes = Infante::with('ciudadano')->get();
        return view('Archivo.Infantes.index', [
            'infantes' => $infantes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ciudadanos = Ciudadano::get();

        return view('Archivo.Infantes.create', [
            'ciudadanos' => $ciudadanos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInfanteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInfanteRequest $request)
    {
        try {
            DB::beginTransaction();

            $infante = new Infante();
            $infante->nombre = $request->nombre;
            $infante->apellido = $request->apellido;
            $infante->slug = Str::slug($request->nombre." ".$request->apellido);
            if ($request->sexo) {
                $infante->sexo = 'M';
            } else {
                $infante->sexo = 'F';
            }
            $infante->nacimiento = date('Y-m-d', strtotime($request->nacimiento));
            $infante->ciudadano_id = $request->responsable;
            $infante->save();

            $log = new Log();
            $log->accion = "Registrar nuevo infante ".$infante->nombre." ".$infante->apellido." (".$infante->id.")";
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('infantes.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Infante  $infante
     * @return \Illuminate\Http\Response
     */
    public function show(Infante $infante)
    {        
        return view('Archivo.Infantes.show', [
            'infante' => $infante,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Infante  $infante
     * @return \Illuminate\Http\Response
     */
    public function edit(Infante $infante)
    {
        $ciudadanos = Ciudadano::get();

        return view('Archivo.Infantes.edit', [
            'infante' => $infante,
            'ciudadanos' => $ciudadanos,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInfanteRequest  $request
     * @param  \App\Models\Infante  $infante
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInfanteRequest $request, Infante $infante)
    {
        try {
            DB::beginTransaction();

            $infante->nombre = $request->nombre;
            $infante->apellido = $request->apellido;
            $infante->slug = Str::slug($request->nombre." ".$request->apellido);
            if ($request->sexo) {
                $infante->sexo = 'M';
            } else {
                $infante->sexo = 'F';
            }
            $infante->nacimiento = date('Y-m-d', strtotime($request->nacimiento));
            $infante->ciudadano_id = $request->responsable;
            $infante->save();

            $log = new Log();
            $log->accion = "Editar infante ".$infante->nombre." ".$infante->apellido." (".$infante->id.")";
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('infantes.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Infante  $infante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Infante $infante)
    {
        try {
            DB::beginTransaction();

            $infante->delete();

            $log = new Log();
            $log->accion = "Eliminar infante ".$infante->nombre." ".$infante->apellido." (".$infante->id.")";
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('infantes.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
