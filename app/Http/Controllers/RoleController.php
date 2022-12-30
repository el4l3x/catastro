<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware('can:roles.index')->only('index');
        $this->middleware('can:roles.create')->only('create', 'store');
        $this->middleware('can:roles.edit')->only('edit', 'update');
        $this->middleware('can:roles.destroy')->only('destroy');
    }

    public function index()
    {
        $roles = Role::get();

        return view('Seguridad.Roles.index', [
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        $permisos = Permission::get();

        return view('Seguridad.Roles.create', [
            'permisos' => $permisos,
        ]);
    }

    public function store(StoreRoleRequest $request)
    {
        try {
            DB::beginTransaction();

            $rol = new Role();
            $rol->name = $request->nombre;
            $rol->guard_name = 'web';
            $rol->save();

            $rol->permissions()->sync($request->permisos);

            $log = new Log();
            $log->accion = "Crear nuevo rol de usuario";
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('roles.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function edit(Role $role)
    {
        $permisos = Permission::get();

        return view('Seguridad.Roles.edit', [
            'rol' => $role,
            'permisos' => $permisos,
        ]);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        try {
            DB::beginTransaction();

            $role->name = $request->nombre;
            $role->save();

            $role->permissions()->sync($request->permisos);

            $log = new Log();
            $log->accion = 'Editar rol de usuario '.$role->name.' ('.$role->id.')';
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('roles.index');

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function destroy(Role $role)
    {
        try {
            DB::beginTransaction();

            $role->delete();

            $log = new Log();
            $log->accion = "Eliminar rol de usuario ".$role->name.' ('.$role->id.')';
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('roles.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
