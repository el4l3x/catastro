<?php

namespace App\Http\Controllers;

use App\Models\Comuna;
use App\Http\Requests\StoreComunaRequest;
use App\Http\Requests\UpdateComunaRequest;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ComunaController extends Controller
{
    public function __construct() {
        $this->middleware('can:comunas.index')->only('index');
        $this->middleware('can:comunas.create')->only('create', 'store');
        $this->middleware('can:comunas.edit')->only('edit', 'update');
        $this->middleware('can:comunas.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comunas = Comuna::get();

        return view('Estructuras.Comunas.index', [
            'comunas' => $comunas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Estructuras.Comunas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreComunaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComunaRequest $request)
    {
        try {
            DB::beginTransaction();

            $comuna = new Comuna();
            $comuna->nombre = $request->nombre;
            $comuna->slug = Str::slug($request->nombre);
            $comuna->save();

            $log =  new Log();
            $log->user_id = Auth::user()->id;
            $log->accion = "Crear nueva Comuna ".$request->nombre." (".$comuna->id.")";
            $log->save();

            DB::commit();

            return redirect()->route('comunas.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comuna  $comuna
     * @return \Illuminate\Http\Response
     */
    public function edit(Comuna $comuna)
    {
        return view('Estructuras.Comunas.edit', [
            'comuna' => $comuna,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateComunaRequest  $request
     * @param  \App\Models\Comuna  $comuna
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComunaRequest $request, Comuna $comuna)
    {
        try {
            DB::beginTransaction();

            $comuna->nombre = $request->nombre;
            $comuna->slug = Str::slug($request->nombre);
            $comuna->save();
            
            $log = new Log();
            $log->user_id = Auth::user()->id;
            $log->accion = 'Editar comuna '.$comuna->nombre.' ('.$comuna->id.')';
            $log->save();

            DB::commit();

            return redirect()->route('comunas.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comuna  $comuna
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comuna $comuna)
    {
        try {
            DB::beginTransaction();

            $comuna->delete();

            $log = new Log();
            $log->user_id = Auth::user()->id;
            $log->accion = 'Eliminar comuna '.$comuna->nombre.' ('.$comuna->id.')';
            $log->save();

            DB::commit();

            return redirect()->route('comunas.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
