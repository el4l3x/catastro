<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware('can:role.index')->only('index');
    }

    public function index()
    {
        $roles = Role::get();

        return view('Seguridad.Roles.index', [
            'roles' => $roles,
        ]);
    }
}
