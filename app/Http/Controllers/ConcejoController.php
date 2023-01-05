<?php

namespace App\Http\Controllers;

use App\Models\Concejo;
use App\Http\Requests\StoreConcejoRequest;
use App\Http\Requests\UpdateConcejoRequest;
use App\Models\Comuna;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ConcejoController extends Controller
{
    public function __construct() {
        $this->middleware('can:concejos.index')->only('index');
        $this->middleware('can:concejos.create')->only('create', 'store');
        $this->middleware('can:concejos.edit')->only('edit', 'update');
        $this->middleware('can:concejos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $concejos = Concejo::with('comuna')->get();

        return view('Estructuras.Concejos.index', [
            'concejos' => $concejos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $comunas = Comuna::get();

        return view('Estructuras.Concejos.create', [
            'comunas' => $comunas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreConcejoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConcejoRequest $request)
    {
        try {
            DB::beginTransaction();

            $concejo = new Concejo();
            $concejo->nombre = $request->nombre;
            $concejo->slug = Str::slug($request->nombre);
            $concejo->comuna_id = $request->comuna;
            $concejo->save();

            $log = new Log();
            $log->user_id = Auth::user()->id;
            $log->accion = 'Crear nuevo Concejo Comunal '.$request->nombre.' ('.$concejo->id.')';
            $log->save();

            DB::commit();

            return redirect()->route('concejos.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Concejo  $concejo
     * @return \Illuminate\Http\Response
     */
    public function edit(Concejo $concejo)
    {
        $comunas = Comuna::get();

        return view('Estructuras.Concejos.edit', [
            'comunas' => $comunas,
            'concejo' => $concejo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateConcejoRequest  $request
     * @param  \App\Models\Concejo  $concejo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateConcejoRequest $request, Concejo $concejo)
    {
        try {
            DB::beginTransaction();

            $concejo->nombre = $request->nombre;
            $concejo->comuna_id = $request->comuna;
            $concejo->slug = Str::slug($request->nombre);
            $concejo->save();

            $log = new Log();
            $log->user_id = Auth::user()->id;
            $log->accion = 'Editar Concejo Comunal '.$concejo->nombre.' ('.$concejo->id.')';
            $log->save();

            DB::commit();

            return redirect()->route('concejos.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Concejo  $concejo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Concejo $concejo)
    {
        try {
            DB::beginTransaction();

            $concejo->delete();

            $log = new Log();
            $log->user_id = Auth::user()->id;
            $log->accion = 'Eliminar Concejo Comunal '.$concejo->nombre.' ('.$concejo->id.')';
            $log->save();

            DB::commit();

            return redirect()->route('concejos.index');

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
