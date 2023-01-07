<?php

namespace App\Http\Controllers;

use App\Models\Parroquia;
use App\Http\Requests\StoreParroquiaRequest;
use App\Http\Requests\UpdateParroquiaRequest;
use App\Models\Ciudadano;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ParroquiaController extends Controller
{
    public function __construct() {
        $this->middleware('can:parroquias.index')->only('index');
        $this->middleware('can:parroquias.create')->only('create', 'store');
        $this->middleware('can:parroquias.edit')->only('edit', 'update');
        $this->middleware('can:parroquias.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parroquias = Parroquia::get();

        return view('Estructuras.Parroquias.index', [
            'parroquias' => $parroquias,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Estructuras.Parroquias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreParroquiaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreParroquiaRequest $request)
    {
        try {
            DB::beginTransaction();

            $parroquia = new Parroquia();
            $parroquia->nombre = $request->nombre;
            $parroquia->slug = Str::slug($request->nombre);
            $parroquia->save();

            $log = new Log();
            $log->user_id = Auth::user()->id;
            $log->accion = 'Crear nueva Parroquia '.$parroquia->nombre.' ('.$parroquia->id.')';
            $log->save();

            DB::commit();

            return redirect()->route('parroquias.index');

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parroquia  $parroquia
     * @return \Illuminate\Http\Response
     */
    public function show(Parroquia $parroquia)
    {
        $poblacion = Ciudadano::where('parroquia_id', $parroquia->id)->count();
        $aumentop = Ciudadano::where('parroquia_id', $parroquia->id)->whereDate('created_at', '>', date('Y-m-d', strtotime('now - 1 week')))->count();
        $genero = Ciudadano::where('parroquia_id', $parroquia->id)->where('sexo', 'M')->count();
        $edadm = Ciudadano::where('parroquia_id', $parroquia->id)->whereDate('nacimiento', '>', date('Y-m-d', strtotime('now - 18 year')))->count();
        $abuelos = Ciudadano::where('parroquia_id', $parroquia->id)->whereDate('nacimiento', '<', date('Y-m-d', strtotime('now - 60 year')))->count();
        
        return view('Estructuras.Parroquias.show', [
            'parroquia' => $parroquia,
            'poblacion' => $poblacion,
            'aumentop' => $aumentop,
            'genero' => $genero,
            'edadm' => $edadm,
            'abuelos' => $abuelos,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Parroquia  $parroquia
     * @return \Illuminate\Http\Response
     */
    public function edit(Parroquia $parroquia)
    {
        return view('Estructuras.Parroquias.edit', [
            'parroquia' => $parroquia,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateParroquiaRequest  $request
     * @param  \App\Models\Parroquia  $parroquia
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateParroquiaRequest $request, Parroquia $parroquia)
    {
        try {
            DB::beginTransaction();

            $parroquia->nombre = $request->nombre;
            $parroquia->slug = Str::slug($request->nombre);
            $parroquia->save();

            $log = new Log();
            $log->user_id = Auth::user()->id;
            $log->accion = 'Editar Parroquia '.$parroquia->nombre.' ('.$parroquia->id.')';
            $log->save();

            DB::commit();

            return redirect()->route('parroquias.index');

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parroquia  $parroquia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parroquia $parroquia)
    {
        try {
            DB::beginTransaction();

            $parroquia->delete();

            $log = new Log();
            $log->user_id = Auth::user()->id;
            $log->accion = 'Eliminar Parroquia '.$parroquia->nombre.' ('.$parroquia->id.')';
            $log->save();

            DB::commit();

            return redirect()->route('parroquias.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
