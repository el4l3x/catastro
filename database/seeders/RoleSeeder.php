<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdm = Role::create(['name' => 'Admin']);
        $roleReg = Role::create(['name' => 'Registrador']);
        $roleObs = Role::create(['name' => 'Observador']);
        $roleSup = Role::create(['name' => 'Supervisor']);

        Permission::create([
            'name' => 'logs.index',
            'description' => 'Ver Bitacora',
        ])->syncRoles([$roleAdm, $roleObs, $roleSup]);

        Permission::create([
            'name' => 'roles.index',
            'description' => 'Ver Roles de Usuarios',
        ])->syncRoles([$roleAdm, $roleObs, $roleSup]);
        Permission::create([
            'name' => 'roles.create',
            'description' => 'Crear un Rol de Usuario',
        ])->syncRoles([$roleAdm, $roleReg, $roleSup]);
        Permission::create([
            'name' => 'roles.edit',
            'description' => 'Editar un Rol de Usuario',
        ])->syncRoles([$roleAdm, $roleSup]);
        Permission::create([
            'name' => 'roles.destroy',
            'description' => 'Eliminar un Rol de Usuario',
        ])->syncRoles([$roleAdm, $roleSup]);
        
        Permission::create([
            'name' => 'usuarios.index',
            'description' => 'Ver Usuarios',
        ])->syncRoles([$roleAdm, $roleObs, $roleSup]);
        Permission::create([
            'name' => 'usuarios.create',
            'description' => 'Crear un Usuario',
        ])->syncRoles([$roleAdm, $roleSup]);
        Permission::create([
            'name' => 'usuarios.edit',
            'description' => 'Editar un Usuario',
        ])->syncRoles([$roleAdm, $roleSup]);
        Permission::create([
            'name' => 'usuarios.destroy',
            'description' => 'Eliminar un Usuario',
        ])->syncRoles([$roleAdm, $roleSup]);
    }
}
