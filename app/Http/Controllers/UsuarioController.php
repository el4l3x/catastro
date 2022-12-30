<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Rules\Password;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function __construct() {
        $this->middleware("can:usuarios.index")->only('index');
        $this->middleware("can:usuarios.create")->only('create', 'store');
        $this->middleware("can:usuarios.edit")->only('edit', 'update');
        $this->middleware("can:usuarios.destroy")->only('destroy');
    }

    public function index()
    {
        $usuarios = User::get();

        return view('Seguridad.Users.index', [
            'usuarios' => $usuarios,
        ]);
    }

    public function create()
    {
        $roles = Role::get();
        return view('Seguridad.Users.create', [
            'roles' => $roles,
        ]);
    }

    public function store(StoreUsuarioRequest $request)
    {
        Validator::make($request->all(), [
            'clave' => ['required', 'string', new Password, 'confirmed'],
        ])->validate();

        try {
            DB::beginTransaction();

            $user = new User();
            $user->name = $request->nombre;
            $user->usuario = $request->usuario;
            $user->password = Hash::make($request->clave);
            $user->save();

            $user->roles()->sync($request->rol);

            $log = new Log();
            $log->accion = "Crear nuevo usuario ".$user->usuario.' ('.$user->id.')';
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('usuarios.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function edit(User $usuario)
    {
        $roles = Role::get();
        return view('Seguridad.Users.edit', [
            'roles' => $roles,
            'user' => $usuario,
        ]);
    }

    public function update(UpdateUsuarioRequest $request, User $usuario)
    {
        Validator::make($request->all(), [
            'usuario' => 'required|unique:users,usuario,'.$usuario->id,
        ])->validate();

        try {
            DB::beginTransaction();

            $usuario->name = $request->nombre;
            $usuario->usuario = $request->usuario;
            $usuario->save();

            $usuario->roles()->sync($request->rol);

            $log = new Log();
            $log->accion = "Editar usuario ".$usuario->name.' ('.$usuario->id.')';
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('usuarios.index');

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function destroy(User $usuario)
    {
        try {
            DB::beginTransaction();

            $usuario->delete();

            $log = new Log();
            $log->accion = "Eliminar producto ".$usuario->nombre.' ('.$usuario->id.')';
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('usuarios.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
